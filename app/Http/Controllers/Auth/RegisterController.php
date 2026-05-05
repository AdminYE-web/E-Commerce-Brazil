<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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
    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
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

   $fullName = trim($request->first_name . ' ' . $request->last_name);

$user = User::create([
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'name' => $fullName,
    'email' => strtolower($request->email),
    'password' => $request->password,
    'status' => 2,
    'term_policy' => $request->boolean('term_policy'),
    'receive_email' => $request->boolean('receive_email'),
    'email_verified_at' => null,
]);

    event(new Registered($user));

    return redirect()->route('login')
        ->with('message', 'Registration successful. Please check your email to verify your account before logging in.');
}
}