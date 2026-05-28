<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountAddressController extends Controller
{
    private array $allowedTypes = ['shipping', 'billing'];

    public function index(string $type = 'shipping')
    {
        if (! in_array($type, $this->allowedTypes, true)) {
            abort(404);
        }

        $user = auth()->user();

        $addresses = UserAddress::where('user_id', $user->user_id)
            ->where('address_type', $type)
            ->where('is_active', 1)
            ->orderByDesc('is_main')
            ->orderBy('created_at')
            ->get();

        return view('account.addresses.index', compact('user', 'addresses', 'type'));
    }

    public function create(string $type)
    {
        if (! in_array($type, $this->allowedTypes, true)) {
            abort(404);
        }

        $user = auth()->user();

        $addressCount = UserAddress::where('user_id', $user->user_id)
            ->where('address_type', $type)
            ->where('is_active', 1)
            ->count();

        if ($addressCount >= 5) {
            return redirect()
                ->route('account.addresses.index', $type)
                ->with('error', 'You can add up to 5 '.$type.' addresses only.');
        }

        return view('account.addresses.create', compact('user', 'type'));
    }

    public function store(Request $request, string $type)
    {
        if (! in_array($type, $this->allowedTypes, true)) {
            abort(404);
        }

        $user = auth()->user();

        $addressCount = UserAddress::where('user_id', $user->user_id)
            ->where('address_type', $type)
            ->where('is_active', 1)
            ->count();

        if ($addressCount >= 5) {
            return redirect()
                ->route('account.addresses.index', $type)
                ->with('error', 'You can add up to 5 '.$type.' addresses only.');
        }

        $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:50'],
            'is_main' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $user, $type, $addressCount) {
            $isMain = $request->boolean('is_main') || $addressCount === 0;

            if ($isMain) {
                UserAddress::where('user_id', $user->user_id)
                    ->where('address_type', $type)
                    ->update(['is_main' => 0]);
            }

            UserAddress::create([
                'user_id' => $user->user_id,
                'address_type' => $type,

                'label' => $request->label,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,

                'company_name' => $request->company_name,
                'address' => $request->address,
                'apartment' => $request->apartment,

                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,

                'is_main' => $isMain ? 1 : 0,
                'is_active' => 1,
            ]);
        });

        return redirect()
            ->route('account.addresses.index', $type)
            ->with('success', ucfirst($type).' address created successfully.');
    }

    public function setMain(UserAddress $address)
    {
        $user = auth()->user();

        if ((int) $address->user_id !== (int) $user->user_id) {
            abort(403);
        }

        DB::transaction(function () use ($user, $address) {
            UserAddress::where('user_id', $user->user_id)
                ->where('address_type', $address->address_type)
                ->update(['is_main' => 0]);

            $address->update([
                'is_main' => 1,
            ]);
        });

        return redirect()
            ->route('account.addresses.index', $address->address_type)
            ->with('success', 'Main address updated.');
    }

    public function destroy(UserAddress $address)
    {
        $user = auth()->user();

        if ((int) $address->user_id !== (int) $user->user_id) {
            abort(403);
        }

        $type = $address->address_type;
        $wasMain = $address->is_main;

        $address->delete();

        if ($wasMain) {
            $newMain = UserAddress::where('user_id', $user->user_id)
                ->where('address_type', $type)
                ->where('is_active', 1)
                ->orderBy('created_at')
                ->first();

            if ($newMain) {
                $newMain->update(['is_main' => 1]);
            }
        }

        return redirect()
            ->route('account.addresses.index', $type)
            ->with('success', ucfirst($type).' address deleted successfully.');
    }

    public function edit(UserAddress $address)
    {
        $user = auth()->user();

        if ((int) $address->user_id !== (int) $user->user_id) {
            abort(403);
        }

        $type = $address->address_type;

        return view('account.addresses.edit', compact('user', 'address', 'type'));
    }

    public function update(Request $request, UserAddress $address)
    {
        $user = auth()->user();

        if ((int) $address->user_id !== (int) $user->user_id) {
            abort(403);
        }

        $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:50'],
            'is_main' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $user, $address) {
            $isMain = $request->boolean('is_main');

            if ($isMain) {
                UserAddress::where('user_id', $user->user_id)
                    ->where('address_type', $address->address_type)
                    ->update(['is_main' => 0]);
            }

            $address->update([
                'label' => $request->label,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'is_main' => $isMain ? 1 : $address->is_main,
            ]);
        });

        return redirect()
            ->route('account.addresses.index', $address->address_type)
            ->with('success', ucfirst($address->address_type).' address updated successfully.');
    }
}
