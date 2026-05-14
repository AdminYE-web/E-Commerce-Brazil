<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountContactController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $contacts = UserContact::where('user_id', $user->user_id)
            ->where('is_active', 1)
            ->orderByDesc('is_main')
            ->orderBy('created_at')
            ->get();

        return view('account.contacts.index', compact('user', 'contacts'));
    }

    public function create()
    {
        $user = auth()->user();

        $contactCount = UserContact::where('user_id', $user->user_id)
            ->where('is_active', 1)
            ->count();

        if ($contactCount >= 5) {
            return redirect()
                ->route('account.contacts.index')
                ->with('error', 'You can add up to 5 contacts only.');
        }

        return view('account.contacts.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $contactCount = UserContact::where('user_id', $user->user_id)
            ->where('is_active', 1)
            ->count();

        if ($contactCount >= 5) {
            return redirect()
                ->route('account.contacts.index')
                ->with('error', 'You can add up to 5 contacts only.');
        }

        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'is_main' => ['nullable', 'boolean'],
            'receive_email' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $user, $contactCount) {
            $isMain = $request->boolean('is_main') || $contactCount === 0;

            if ($isMain) {
                UserContact::where('user_id', $user->user_id)
                    ->update(['is_main' => 0]);
            }

            UserContact::create([
                'user_id' => $user->user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => strtolower($request->email),
                'is_main' => $isMain ? 1 : 0,
                'receive_email' => $request->boolean('receive_email') ? 1 : 0,
                'is_active' => 1,
            ]);
        });

        return redirect()
            ->route('account.contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function setMain(UserContact $contact)
    {
        $user = auth()->user();

        if ((int) $contact->user_id !== (int) $user->user_id) {
            abort(403);
        }

        DB::transaction(function () use ($user, $contact) {
            UserContact::where('user_id', $user->user_id)
                ->update(['is_main' => 0]);

            $contact->update([
                'is_main' => 1,
            ]);
        });

        return redirect()
            ->route('account.contacts.index')
            ->with('success', 'Main contact updated.');
    }

    public function destroy(UserContact $contact)
    {
        $user = auth()->user();

        if ((int) $contact->user_id !== (int) $user->user_id) {
            abort(403);
        }

        $wasMain = $contact->is_main;

        $contact->delete();

        if ($wasMain) {
            $newMain = UserContact::where('user_id', $user->user_id)
                ->where('is_active', 1)
                ->orderBy('created_at')
                ->first();

            if ($newMain) {
                $newMain->update(['is_main' => 1]);
            }
        }

        return redirect()
            ->route('account.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
    public function edit(UserContact $contact)
{
    $user = auth()->user();

    if ((int) $contact->user_id !== (int) $user->user_id) {
        abort(403);
    }

    return view('account.contacts.edit', compact('user', 'contact'));
}

public function update(Request $request, UserContact $contact)
{
    $user = auth()->user();

    if ((int) $contact->user_id !== (int) $user->user_id) {
        abort(403);
    }

    $request->validate([
        'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'],
        'phone' => ['required', 'string', 'max:50'],
        'email' => ['required', 'email', 'max:255'],
        'is_main' => ['nullable', 'boolean'],
        'receive_email' => ['nullable', 'boolean'],
    ]);

    DB::transaction(function () use ($request, $user, $contact) {
        $isMain = $request->boolean('is_main');

        if ($isMain) {
            UserContact::where('user_id', $user->user_id)
                ->update(['is_main' => 0]);
        }

        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => strtolower($request->email),
            'is_main' => $isMain ? 1 : $contact->is_main,
            'receive_email' => $request->boolean('receive_email') ? 1 : 0,
        ]);
    });

    return redirect()
        ->route('account.contacts.index')
        ->with('success', 'Contact updated successfully.');
}
}