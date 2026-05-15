<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterSendVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\UserContact;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['required', 'string', 'max:50'],
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[0-9]/',
            'regex:/[A-Z]/',
        ],
        'term_policy' => ['accepted'],
        'receive_email' => ['nullable'],
    ], [
        'password.regex' => 'Password must contain at least 1 number and 1 uppercase letter.',
        'term_policy.accepted' => 'Please accept the Terms and Conditions.',
    ]);

    $email = strtolower($request->email);

    $existingUser = User::where('email', $email)->first();

    /*
    |--------------------------------------------------------------------------
    | Case 1: Email already exists and account is active
    |--------------------------------------------------------------------------
    */
    if ($existingUser && (int) $existingUser->status === 1) {
        return back()
            ->withErrors([
                'email' => 'This email is already registered. Please login instead.',
            ])
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | Case 2: Email exists but not verified yet
    |--------------------------------------------------------------------------
    | Update latest information and resend verification email
    |--------------------------------------------------------------------------
    */
    if ($existingUser && (int) $existingUser->status === 2) {
        $fullName = trim($request->first_name . ' ' . $request->last_name);

        $existingUser->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'phone' => $request->phone,
            'password' => $request->password,
            'term_policy' => $request->boolean('term_policy'),
            'receive_email' => $request->boolean('receive_email'),
            'email_verified_at' => null,
        ]);
        UserContact::updateOrCreate(
    [
        'user_id' => $existingUser->user_id,
        'is_main' => 1,
    ],
    [
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $email,
        'phone' => $request->phone,
        'status' => 1,
    ]
);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(5),
            [
                'id' => $existingUser->user_id,
                'hash' => sha1($existingUser->email),
            ]
        );

        try {
            Mail::to($existingUser->email)->send(
                new RegisterSendVerification($existingUser, $verificationUrl)
            );

            return redirect()->route('login')
                ->with('message', 'A new verification email has been sent. Please check your email to verify your account.');

        } catch (\Exception $e) {
            return back()
                ->withErrors([
                    'email' => 'Unable to send verification email. Error: ' . $e->getMessage(),
                ])
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Case 3: New email, create new user
    |--------------------------------------------------------------------------
    */
    $fullName = trim($request->first_name . ' ' . $request->last_name);

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'name' => $fullName,
        'email' => $email,
        'phone' => $request->phone,
        'password' => $request->password,
        'status' => 2,
        'term_policy' => $request->boolean('term_policy'),
        'receive_email' => $request->boolean('receive_email'),
        'email_verified_at' => null,
    ]);

    UserContact::create([
    'user_id' => $user->user_id,
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'email' => $email,
    'phone' => $request->phone,
    'is_main' => 1,
    'status' => 1,
]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(5),
        [
            'id' => $user->user_id,
            'hash' => sha1($user->email),
        ]
    );

    try {
        Mail::to($user->email)->send(
            new RegisterSendVerification($user, $verificationUrl)
        );

        return redirect()->route('login')
            ->with('message', 'Registration successful. Please check your email to verify your account before logging in.');

    } catch (\Exception $e) {
        return back()
            ->withErrors([
                'email' => 'Unable to send verification email. Error: ' . $e->getMessage(),
            ])
            ->withInput();
    }
}
}
