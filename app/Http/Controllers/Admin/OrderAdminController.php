<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'payment'])
            ->orderBy('order_id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery
                            ->where('personal_email', 'like', "%{$search}%")
                            ->orWhere('personal_first_name', 'like', "%{$search}%")
                            ->orWhere('personal_last_name', 'like', "%{$search}%")
                            ->orWhere('personal_phone', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->whereHas('payment', function ($paymentQuery) use ($request) {
                $paymentQuery->where('payment_status', $request->payment_status);
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load([
            'items',
            'customer',
            'payment',
            'artworks',
        ]);

        return view('admin.orders.show', compact('order'));
    }

   public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:order_pending,design_in_progress,production,delivery,delivered,completed,cancelled',
        'payment_status' => 'nullable|in:pending,paid,failed,cancelled,refunded',
    ]);

    $order->update([
        'order_status' => $request->status,
        'payment_status' => $request->payment_status ?? $order->payment_status,
    ]);

    return redirect()
        ->route('admin.orders.show', $order->order_id)
        ->with('success', 'Order status updated successfully.');
}
}