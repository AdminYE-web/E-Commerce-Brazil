<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        $this->configureSocialiteHttpClient();

        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function handleGoogleCallback()
    {
        $this->configureSocialiteHttpClient();

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error('Google OAuth callback failed: '.$e->getMessage());

            return redirect()->route('login')
                ->withErrors(['email' => __('messages.auth.google_login_failed')]);
        }

        // Check if this Google account is already linked to a user
        $socialAccount = SocialAccount::where('provider', 'google')
            ->where('provider_id', $googleUser->getId())
            ->first();

        if ($socialAccount) {
            // Existing social account — log the user in
            $user = $socialAccount->user;

            // Update the social account details (avatar, name may change)
            $socialAccount->update([
                'provider_email' => $googleUser->getEmail(),
                'provider_name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            // No linked social account — find or create user by email
            DB::beginTransaction();

            try {
                $user = User::where('email', strtolower($googleUser->getEmail()))->first();

                if (! $user) {
                    // Create a brand-new user (no password needed for social login)
                    $nameParts = $this->splitName($googleUser->getName());

                    $user = User::create([
                        'first_name' => $nameParts['first_name'],
                        'last_name' => $nameParts['last_name'],
                        'name' => $googleUser->getName(),
                        'email' => strtolower($googleUser->getEmail()),
                        'password' => null,
                        'status' => 1, // Google-verified email, activate immediately
                        'term_policy' => true,
                        'receive_email' => true,
                        'email_verified_at' => now(),
                    ]);
                } else {
                    // Existing user — ensure email is verified
                    if (is_null($user->email_verified_at)) {
                        $user->update([
                            'email_verified_at' => now(),
                            'status' => 1,
                        ]);
                    }
                }

                // Link the Google account to the user
                SocialAccount::create([
                    'user_id' => $user->user_id,
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'provider_email' => $googleUser->getEmail(),
                    'provider_name' => $googleUser->getName(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Google OAuth user creation failed: '.$e->getMessage());

                return redirect()->route('login')
                    ->withErrors(['email' => __('messages.auth.google_login_failed')]);
            }
        }

        // Log the user in
        Auth::login($user, true);

        $user->update(['last_login_at' => now()]);

        return redirect()->intended('/');
    }

    /**
     * Configure Socialite's HTTP client to handle SSL certificate issues
     * commonly found on Windows with Herd.
     */
    private function configureSocialiteHttpClient(): void
    {
        if (app()->environment('local')) {
            Socialite::driver('google')->setHttpClient(
                new \GuzzleHttp\Client(['verify' => false])
            );
        }
    }

    /**
     * Split a full name into first and last name.
     */
    private function splitName(?string $fullName): array
    {
        if (empty($fullName)) {
            return ['first_name' => '', 'last_name' => ''];
        }

        $parts = explode(' ', trim($fullName), 2);

        return [
            'first_name' => $parts[0] ?? '',
            'last_name' => $parts[1] ?? '',
        ];
    }
}
