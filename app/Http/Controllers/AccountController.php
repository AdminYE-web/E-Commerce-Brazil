<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('account.index', compact('user'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = auth()->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update([
            'avatar' => $path,
        ]);

        return redirect()
            ->route('account.index')
            ->with('success', 'Profile image updated successfully.');
    }
    public function updateName(Request $request)
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'],
    ]);

    $user = auth()->user();

    $fullName = trim($request->first_name . ' ' . $request->last_name);

    $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'name' => $fullName,
    ]);

    return redirect()
        ->route('account.index')
        ->with('success', 'Name updated successfully.');
}
public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required', 'string'],
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[0-9]/',
            'regex:/[A-Z]/',
        ],
    ], [
        'password.regex' => 'Password must contain at least 1 number and 1 uppercase letter.',
    ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()
            ->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()
        ->route('account.index')
        ->with('success', 'Password updated successfully.');
}
}