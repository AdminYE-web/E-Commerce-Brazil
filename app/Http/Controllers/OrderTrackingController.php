<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('orders.track');
    }

    public function search(Request $request)
    {
        $request->validate([
            'order_no' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $order = Order::with(['customer'])
            ->where('order_no', $request->order_no)
            ->whereHas('customer', function ($query) use ($request) {
                $query->where('personal_email', strtolower($request->email));
            })
            ->first();

        if (! $order) {
            return back()
                ->withErrors([
                    'order_no' => 'Order not found or email does not match this order.',
                ])
                ->withInput();
        }

        session([
            'tracking_order_email_' . $order->order_id => strtolower($request->email),
        ]);

        return redirect()->route('track-order.result', $order->order_id);
    }

    public function result(Order $order)
    {
        $trackingEmail = session('tracking_order_email_' . $order->order_id);

        if (! $trackingEmail) {
            return redirect()
                ->route('track-order.index')
                ->withErrors([
                    'order_no' => 'Please enter your order number and email first.',
                ]);
        }

        $order->load([
            'customer',
            'items',
            'payment',
            'artworks',
        ]);

        if (strtolower($order->customer->personal_email ?? '') !== strtolower($trackingEmail)) {
            abort(403);
        }

        return view('orders.track-result', compact('order'));
    }
}