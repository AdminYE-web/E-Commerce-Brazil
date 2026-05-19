<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->filled('redirect')) {
            session()->put('url.intended', $request->redirect);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Email or password is incorrect.'])
                ->withInput();
        }

        if ((int) $user->status !== 1) {
            return back()
                ->withErrors(['email' => 'Please verify your email before logging in.'])
                ->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        $user->recordLogin($request, 'email');

        return redirect()->intended(route('checkout.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
