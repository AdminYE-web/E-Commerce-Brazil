<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $status = $request->get('status');
        $search = $request->get('search');

        $orders = Order::with([
                'items.optionDetails',
                'payment',
            ])
            ->where('user_id', $user->user_id)
            ->when($status && $status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_no', 'like', '%' . $search . '%')
                        ->orWhereHas('items', function ($itemQuery) use ($search) {
                            $itemQuery->where('product_name_snapshot', 'like', '%' . $search . '%')
                                ->orWhere('product_name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderBy('order_id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('account.orders.index', compact('user', 'orders', 'status', 'search'));
    }
}