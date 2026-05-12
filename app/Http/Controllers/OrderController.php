<?php

namespace App\Http\Controllers;

use App\Models\OrderItemOption;
use App\Models\Order;
use App\Models\OrderArtwork;
use App\Models\OrderCustomer;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $productIds = collect($cart)
            ->pluck('product_id')
            ->filter()
            ->unique()
            ->values();

        $products = Product::with('artworkTemplates')
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id');

        return view('checkout.index', $this->getCheckoutViewData([
            'products' => $products,
        ]));
    }

    // public function placeOrder(Request $request)
    // {
    //     $request->validate([
    //         'personal_first_name' => 'required|string|max:255',
    //         'personal_last_name' => 'required|string|max:255',
    //         'personal_phone' => 'required|string|max:50',
    //         'personal_email' => 'required|email|max:255',

    //         'shipping_postcode' => 'required|string|max:20',
    //         'shipping_province' => 'required|string|max:255',
    //         'shipping_district' => 'required|string|max:255',
    //         'shipping_subdistrict' => 'required|string|max:255',
    //         'shipping_building_room' => 'nullable|string|max:255',
    //         'shipping_address' => 'required|string',

    //         'billing_first_name' => 'required|string|max:255',
    //         'billing_last_name' => 'required|string|max:255',
    //         'billing_phone' => 'required|string|max:50',
    //         'billing_email' => 'required|email|max:255',

    //         'billing_postcode' => 'required|string|max:20',
    //         'billing_province' => 'required|string|max:255',
    //         'billing_district' => 'required|string|max:255',
    //         'billing_subdistrict' => 'required|string|max:255',
    //         'billing_building_room' => 'nullable|string|max:255',
    //         'billing_address' => 'required|string',

    //         'payment_method' => 'required|string|max:100',
    //     ]);

    //     $cart = session()->get('cart', []);

    //     if (empty($cart)) {
    //         return redirect()
    //             ->route('cart.index')
    //             ->with('error', 'Your cart is empty.');
    //     }

    //     $cartItems = collect($cart);

    //     $subtotal = $cartItems->sum(fn ($item) => (float) ($item['item_total'] ?? 0));
    //     $totalQuantity = $cartItems->sum(fn ($item) => (int) ($item['quantity'] ?? 0));
    //     $totalItems = $cartItems->count();

    //     $shippingFee = $subtotal > 10000 ? 0 : 800;
    //     $taxAmount = 20;
    //     $grandTotal = $subtotal + $shippingFee + $taxAmount;

    //     DB::beginTransaction();

    //     try {
    //         $order = Order::create([
    //             'order_no' => $this->generateOrderNo(),
    //             'total_items' => $totalItems,
    //             'total_quantity' => $totalQuantity,
    //             'subtotal' => $subtotal,
    //             'shipping_fee' => $shippingFee,
    //             'tax_amount' => $taxAmount,
    //             'grand_total' => $grandTotal,
    //             'currency' => 'JPY',
    //             'order_status' => 'pending',
    //         ]);

    //         OrderCustomer::create([
    //             'order_id' => $order->order_id,

    //             'personal_first_name' => $request->personal_first_name,
    //             'personal_last_name' => $request->personal_last_name,
    //             'personal_phone' => $request->personal_phone,
    //             'personal_email' => $request->personal_email,

    //             'shipping_postcode' => $request->shipping_postcode,
    //             'shipping_province' => $request->shipping_province,
    //             'shipping_district' => $request->shipping_district,
    //             'shipping_subdistrict' => $request->shipping_subdistrict,
    //             'shipping_building_room' => $request->shipping_building_room,
    //             'shipping_address' => $request->shipping_address,

    //             'billing_first_name' => $request->billing_first_name,
    //             'billing_last_name' => $request->billing_last_name,
    //             'billing_phone' => $request->billing_phone,
    //             'billing_email' => $request->billing_email,
    //             'billing_postcode' => $request->billing_postcode,
    //             'billing_province' => $request->billing_province,
    //             'billing_district' => $request->billing_district,
    //             'billing_subdistrict' => $request->billing_subdistrict,
    //             'billing_building_room' => $request->billing_building_room,
    //             'billing_address' => $request->billing_address,
    //         ]);

    //         OrderPayment::create([
    //             'order_id' => $order->order_id,
    //             'transaction_id' => null,
    //             'payment_method' => $request->payment_method,
    //             'payment_status' => 'pending',
    //             'amount' => $grandTotal,
    //             'currency' => 'JPY',
    //             'paid_at' => null,
    //             'payment_response' => null,
    //         ]);

    //         DB::commit();

    //         session()->forget('cart');

    //         return redirect()
    //             ->route('checkout.index')
    //             ->with('success', 'Order placed successfully. Order No: '.$order->order_no);

    //     } catch (\Throwable $e) {
    //         DB::rollBack();

    //         return back()
    //             ->withInput()
    //             ->with('error', $e->getMessage());
    //     }
    // }

    // private function generateOrderNo()
    // {
    //     return 'ORD'.date('YmdHis').rand(100, 999);
    // }

    public function storeArtworkStep(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'artwork_files' => 'nullable|array',
            'artwork_files.*' => 'nullable|array',
            'artwork_files.*.*' => 'nullable|file|mimes:ai,pdf,jpeg,jpg,png,psd,zip,eps|max:10240',

            'no_artwork' => 'nullable|array',
            'print_text' => 'nullable|array',
            'font_option' => 'nullable|array',
            'font_other' => 'nullable|array',
            'template_id' => 'nullable|array',
        ]);

        $artworkFiles = $request->file('artwork_files', []);
        $noArtwork = $request->input('no_artwork', []);
        $printText = $request->input('print_text', []);
        $fontOption = $request->input('font_option', []);
        $fontOther = $request->input('font_other', []);
        $templateIds = $request->input('template_id', []);

        $artworkSession = [];

        foreach ($cart as $cartItemId => $item) {
            $uploadedFiles = [];

            if (isset($artworkFiles[$cartItemId]) && is_array($artworkFiles[$cartItemId])) {
                foreach ($artworkFiles[$cartItemId] as $file) {
                    if (! $file) {
                        continue;
                    }

                    $path = $file->store('checkout-artworks', 'public');

                    $uploadedFiles[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ];
                }
            }

            $artworkSession[$cartItemId] = [
                'cart_item_id' => $cartItemId,
                'product_id' => $item['product_id'] ?? null,

                'files' => $uploadedFiles,

                'no_artwork' => isset($noArtwork[$cartItemId]) ? true : false,

                'print_text' => $printText[$cartItemId] ?? null,
                'font_option' => $fontOption[$cartItemId] ?? null,
                'font_other' => $fontOther[$cartItemId] ?? null,

                'template_id' => $templateIds[$cartItemId] ?? null,
            ];
        }

        session()->put('checkout_artworks', $artworkSession);

        // Debug ชั่วคราว
        // dd(session('checkout_artworks'));

        return redirect()
            ->route('checkout.address')
            ->with('success', 'Artwork information saved.');
    }

    public function address()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.address', $this->getCheckoutViewData());
    }

    public function storeAddressStep(Request $request)
    {
        $request->validate([
            'personal_first_name' => 'required|string|max:255',
            'personal_last_name' => 'required|string|max:255',
            'personal_phone' => 'required|string|max:50',
            'personal_email' => 'required|email|max:255',

            'shipping_postcode' => 'required|string|max:20',
            'shipping_province' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_area' => 'required|string|max:255',
            'shipping_building_room' => 'required|string|max:255',

            'billing_same_as_shipping' => 'nullable|boolean',

            'billing_first_name' => 'nullable|string|max:255',
            'billing_last_name' => 'nullable|string|max:255',
            'billing_phone' => 'nullable|string|max:50',
            'billing_email' => 'nullable|email|max:255',
            'billing_postcode' => 'nullable|string|max:20',
            'billing_province' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_area' => 'nullable|string|max:255',
            'billing_building_room' => 'nullable|string|max:255',
        ]);

        $billingSame = $request->has('billing_same_as_shipping');

        $customer = [
            'personal' => [
                'first_name' => $request->personal_first_name,
                'last_name' => $request->personal_last_name,
                'phone' => $request->personal_phone,
                'email' => $request->personal_email,
            ],

            'shipping' => [
                'postcode' => $request->shipping_postcode,
                'province' => $request->shipping_province,
                'city' => $request->shipping_city,
                'area' => $request->shipping_area,
                'building_room' => $request->shipping_building_room,
            ],

            'billing_same_as_shipping' => $billingSame,

            'billing' => $billingSame
                ? [
                    'first_name' => $request->personal_first_name,
                    'last_name' => $request->personal_last_name,
                    'phone' => $request->personal_phone,
                    'email' => $request->personal_email,
                    'postcode' => $request->shipping_postcode,
                    'province' => $request->shipping_province,
                    'city' => $request->shipping_city,
                    'area' => $request->shipping_area,
                    'building_room' => $request->shipping_building_room,
                ]
                : [
                    'first_name' => $request->billing_first_name,
                    'last_name' => $request->billing_last_name,
                    'phone' => $request->billing_phone,
                    'email' => $request->billing_email,
                    'postcode' => $request->billing_postcode,
                    'province' => $request->billing_province,
                    'city' => $request->billing_city,
                    'area' => $request->billing_area,
                    'building_room' => $request->billing_building_room,
                ],
        ];

        session()->put('checkout_customer', $customer);

        return redirect()
            ->route('checkout.payment')
            ->with('success', 'Address information saved.');
    }

    public function payment()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.payment', $this->getCheckoutViewData());
    }

    public function storePaymentStep(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:paypal,bank_transfer',
        ]);

        session()->put('checkout_payment', [
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'transaction_id' => null,
        ]);

        return redirect()
            ->route('checkout.review')
            ->with('success', 'Payment method saved.');
    }

    public function review()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $customer = session('checkout_customer', []);
        $payment = session('checkout_payment', []);

        if (empty($customer)) {
            return redirect()
                ->route('checkout.address')
                ->with('error', 'Please complete address information.');
        }

        if (empty($payment)) {
            return redirect()
                ->route('checkout.payment')
                ->with('error', 'Please select payment method.');
        }

        return view('checkout.review', $this->getCheckoutViewData([
            'payment' => $payment,
        ]));
    }

    private function getCheckoutSummary(array $cart): array
    {
        $cartItems = collect($cart);

        $subtotal = $cartItems->sum(fn ($item) => (float) ($item['item_total'] ?? 0));
        $totalQty = $cartItems->sum(fn ($item) => (int) ($item['quantity'] ?? 0));
        $totalItems = $cartItems->count();

        $shipping = $subtotal > 10000 ? 0 : ($totalItems > 0 ? 800 : 0);
        $tax = $totalItems > 0 ? 20 : 0;
        $grandTotal = $subtotal + $shipping + $tax;

        return compact(
            'cartItems',
            'subtotal',
            'totalQty',
            'totalItems',
            'shipping',
            'tax',
            'grandTotal'
        );
    }

    private function getCheckoutViewData(array $extra = []): array
    {
        $cart = session()->get('cart', []);

        $cartItems = collect($cart);

        $subtotal = $cartItems->sum(fn ($item) => (float) ($item['item_total'] ?? 0));
        $totalQty = $cartItems->sum(fn ($item) => (int) ($item['quantity'] ?? 0));
        $totalItems = $cartItems->count();

        $shipping = $subtotal > 10000 ? 0 : ($totalItems > 0 ? 800 : 0);
        $taxRate = 0.10;
        $tax = $subtotal * $taxRate;
        $grandTotal = $subtotal + $shipping + $tax;

        $customer = session('checkout_customer', []);
        $personal = $customer['personal'] ?? [];
        $shippingAddress = $customer['shipping'] ?? [];
        $billing = $customer['billing'] ?? [];
        $billingSame = $customer['billing_same_as_shipping'] ?? true;

        $artworks = session('checkout_artworks', []);

        return array_merge([
            'cart' => $cart,
            'cartItems' => $cartItems,

            'subtotal' => $subtotal,
            'totalQty' => $totalQty,
            'totalItems' => $totalItems,
            'shipping' => $shipping,
            'tax' => $tax,
            'grandTotal' => $grandTotal,

            'customer' => $customer,
            'personal' => $personal,
            'shippingAddress' => $shippingAddress,
            'billing' => $billing,
            'billingSame' => $billingSame,

            'artworks' => $artworks,
        ], $extra);
    }

    public function placeOrder()
    {
        //    dd('placeOrder called', [
        //     'cart' => session('cart'),
        //     'checkout_artworks' => session('checkout_artworks'),
        //     'checkout_customer' => session('checkout_customer'),
        //     'checkout_payment' => session('checkout_payment'),
        // ]);
        $cart = session()->get('cart', []);
        $customer = session()->get('checkout_customer', []);
        $payment = session()->get('checkout_payment', []);
        $artworks = session()->get('checkout_artworks', []);
        

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        if (empty($customer)) {
            return redirect()
                ->route('checkout.address')
                ->with('error', 'Please complete address information.');
        }

        if (empty($payment)) {
            return redirect()
                ->route('checkout.payment')
                ->with('error', 'Please select payment method.');
        }

        $cartItems = collect($cart);

        $subtotal = $cartItems->sum(fn ($item) => (float) ($item['item_total'] ?? 0));
        $totalQty = $cartItems->sum(fn ($item) => (int) ($item['quantity'] ?? 0));
        $totalItems = $cartItems->count();

        $optionTotal = $cartItems->sum(fn ($item) => (float) ($item['option_total'] ?? 0));

        $shipping = $subtotal > 10000 ? 0 : ($totalItems > 0 ? 800 : 0);

        // VAT 10%
        $vatAmount = $subtotal * 0.10;

        $grandTotal = $subtotal + $shipping + $vatAmount;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_no' => $this->generateOrderNo(),
                'user_id' => auth()->id() ?? null,

                'qty' => $totalQty,
                'base_unit_price' => 0,
                'option_total' => $optionTotal,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'shipping_fee' => $shipping,
                'grand_total' => $grandTotal,

                'status' => 'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Order Items
            |--------------------------------------------------------------------------
            */
            $orderItemMap = [];

            foreach ($cart as $cartItemId => $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item['product_id'] ?? null,

                    'product_name' => $item['product_name'] ?? null,
                    'product_name_snapshot' => $item['product_name'] ?? null,
                    'product_image' => $item['product_image'] ?? null,

                    'qty' => (int) ($item['quantity'] ?? 1),
                    'quantity' => (int) ($item['quantity'] ?? 1),

                    'price_rule_id' => $item['price_rule_id'] ?? null,
                    'price_rule_name' => $item['price_rule_name'] ?? null,

                    'base_unit_price' => (float) ($item['unit_price'] ?? 0),
                    'unit_price' => (float) ($item['unit_price'] ?? 0),

                    'product_total' => (float) ($item['product_total'] ?? 0),
                    'option_total' => (float) ($item['option_total'] ?? 0),
                    'item_total' => (float) ($item['item_total'] ?? 0),

                    'options' => $item['options'] ?? [],
                    'custom_colors' => $item['custom_colors'] ?? [],
                    'base_total' => (float) ($item['product_total'] ?? 0),
                ]);

                $orderItemMap[$cartItemId] = $orderItem->order_item_id;
                /*
                |--------------------------------------------------------------------------
                | Order Item Options
                |--------------------------------------------------------------------------
                */
               $previousOrderNos = $item['previous_order_no'] ?? [];

foreach (($item['options'] ?? []) as $option) {
    $groupId = $option['group_id'] ?? null;

    $additionalPrice = (float) ($option['price'] ?? 0);
    $variantPrice = (float) ($option['variant_price'] ?? 0);
    $totalOptionPrice = $additionalPrice + $variantPrice;

    OrderItemOption::create([
        'order_item_id' => $orderItem->order_item_id,

        'option_group_id' => $groupId,
        'option_id' => $option['option_id'] ?? null,

        'group_name_snapshot' => $option['group_name'] ?? null,
        'option_name_snapshot' => trim(
            ($option['option_name'] ?? '') .
            (!empty($option['variant_name']) ? ' - ' . $option['variant_name'] : '')
        ),

        'additional_price' => $totalOptionPrice,
        'price_type' => $option['price_type'] ?? null,

        'custom_value' => $previousOrderNos[$groupId] ?? null,

        'total_price' => $totalOptionPrice,
    ]);
}

/*
|--------------------------------------------------------------------------
| Custom Colors
|--------------------------------------------------------------------------
*/
foreach (($item['custom_colors'] ?? []) as $customColor) {
    OrderItemOption::create([
        'order_item_id' => $orderItem->order_item_id,

        'option_group_id' => $customColor['group_id'] ?? null,
        'option_id' => null,

        'group_name_snapshot' => $customColor['group_name'] ?? 'Custom Color',
        'option_name_snapshot' => 'Custom Color',

        'additional_price' => 0,
        'price_type' => null,

        'custom_value' => $customColor['value'] ?? null,
        'total_price' => 0,
    ]);
}
            }

            /*
            |--------------------------------------------------------------------------
            | Order Customer
            |--------------------------------------------------------------------------
            */
            $personal = $customer['personal'] ?? [];
            $shippingAddress = $customer['shipping'] ?? [];
            $billing = $customer['billing'] ?? [];

            OrderCustomer::create([
                'order_id' => $order->order_id,

                'personal_first_name' => $personal['first_name'] ?? null,
                'personal_last_name' => $personal['last_name'] ?? null,
                'personal_phone' => $personal['phone'] ?? null,
                'personal_email' => $personal['email'] ?? null,

                'shipping_postcode' => $shippingAddress['postcode'] ?? null,
                'shipping_province' => $shippingAddress['province'] ?? null,
                'shipping_city' => $shippingAddress['city'] ?? null,
                'shipping_area' => $shippingAddress['area'] ?? null,
                'shipping_building_room' => $shippingAddress['building_room'] ?? null,

                'billing_first_name' => $billing['first_name'] ?? null,
                'billing_last_name' => $billing['last_name'] ?? null,
                'billing_phone' => $billing['phone'] ?? null,
                'billing_email' => $billing['email'] ?? null,
                'billing_postcode' => $billing['postcode'] ?? null,
                'billing_province' => $billing['province'] ?? null,
                'billing_city' => $billing['city'] ?? null,
                'billing_area' => $billing['area'] ?? null,
                'billing_building_room' => $billing['building_room'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Order Payment
            |--------------------------------------------------------------------------
            */
            OrderPayment::create([
                'order_id' => $order->order_id,
                'transaction_id' => $payment['transaction_id'] ?? null,
                'payment_method' => $payment['payment_method'] ?? 'bank_transfer',
                'payment_status' => $payment['payment_status'] ?? 'pending',
                'amount' => $grandTotal,
                'currency' => 'JPY',
                'paid_at' => null,
                'payment_response' => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Order Artworks
            |--------------------------------------------------------------------------
            */
            foreach ($artworks as $cartItemId => $artwork) {
                $files = $artwork['files'] ?? [];

                $commonArtworkData = [
                    'order_id' => $order->order_id,
                    'order_item_id' => $orderItemMap[$cartItemId] ?? null,
                    'product_id' => $artwork['product_id'] ?? null,
                    'cart_item_id' => $cartItemId,

                    'no_artwork' => ! empty($artwork['no_artwork']) ? 1 : 0,
                    'print_text' => $artwork['print_text'] ?? null,
                    'font_option' => $artwork['font_option'] ?? null,
                    'font_other' => $artwork['font_other'] ?? null,
                    'template_id' => $artwork['template_id'] ?? null,
                    'status' => 'pending',
                ];

                if (! empty($files)) {
                    foreach ($files as $file) {
                        OrderArtwork::create(array_merge($commonArtworkData, [
                            'file_path' => $file['path'] ?? null,
                            'original_name' => $file['original_name'] ?? null,
                            'mime_type' => $file['mime_type'] ?? null,
                            'file_size' => $file['size'] ?? null,
                        ]));
                    }
                } else {
                    // ไม่มีไฟล์ แต่มี template/text/font/no_artwork ก็ยังควรเก็บ instruction ไว้
                    OrderArtwork::create(array_merge($commonArtworkData, [
                        'file_path' => null,
                        'original_name' => null,
                        'mime_type' => null,
                        'file_size' => null,
                    ]));
                }
            }

            DB::commit();

            session()->forget([
                'cart',
                'checkout_artworks',
                'checkout_customer',
                'checkout_payment',
            ]);

            return redirect()
                ->route('checkout.success', $order->order_id)
                ->with('success', 'Order placed successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        $order->load([
            'items',
            'customer',
            'payment',
            'artworks',
        ]);

        return view('checkout.success', compact('order'));
    }

    private function generateOrderNo(): string
    {
        $prefix = 'ORD'.now()->format('Ymd');

        $latestOrder = Order::where('order_no', 'like', $prefix.'%')
            ->orderBy('order_id', 'desc')
            ->first();

        if (! $latestOrder) {
            return $prefix.'0001';
        }

        $latestNumber = (int) substr($latestOrder->order_no, -4);

        return $prefix.str_pad($latestNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
