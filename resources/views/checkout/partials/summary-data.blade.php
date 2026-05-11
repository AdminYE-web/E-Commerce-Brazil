@php
    $cartItems = collect($cart ?? []);

    $subtotal = $cartItems->sum(fn($item) => (float) ($item['item_total'] ?? 0));
    $totalQty = $cartItems->sum(fn($item) => (int) ($item['quantity'] ?? 0));
    $totalItems = $cartItems->count();

    $shipping = $subtotal > 10000 ? 0 : ($totalItems > 0 ? 800 : 0);
    $tax = $totalItems > 0 ? 20 : 0;
    $grandTotal = $subtotal + $shipping + $tax;

    $customer = session('checkout_customer', []);
    $personal = $customer['personal'] ?? [];
    $shippingAddress = $customer['shipping'] ?? [];
    $billing = $customer['billing'] ?? [];
    $billingSame = $customer['billing_same_as_shipping'] ?? true;
@endphp