<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if (!$user) {
            return back()->with('message', 'If this email exists, we have sent a password reset link.');
        }

        if ((int) $user->status !== 1) {
            return back()->withErrors([
                'email' => 'This account is not active. Please verify your email before resetting your password.',
            ])->withInput();
        }

        $status = Password::sendResetLink([
            'email' => strtolower($request->email),
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('message', 'Password reset link has been sent to your email.');
        }

        return back()->withErrors([
            'email' => 'Unable to send password reset link. Please try again.',
        ])->withInput();
    }
}