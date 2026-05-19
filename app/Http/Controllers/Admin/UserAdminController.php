<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->withCount('orders')
            ->withMax('loginLogs', 'logged_in_at')
            ->orderBy('user_id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($userQuery) use ($search) {
                $userQuery
                    ->where('email', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'mainContact',
            'mainShippingAddress',
            'mainBillingAddress',
            'socialAccounts',
        ]);

        $orders = $user->orders()
            ->with(['customer', 'payment'])
            ->orderBy('order_id', 'desc')
            ->paginate(10, ['*'], 'orders_page');

        $loginLogs = $user->loginLogs()
            ->orderBy('logged_in_at', 'desc')
            ->paginate(10, ['*'], 'logs_page');

        return view('admin.users.show', compact('user', 'orders', 'loginLogs'));
    }
}
