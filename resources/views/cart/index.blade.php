@extends('layouts.app')

@section('title', 'Carrinho')


@section('css')
    <style>
        .cart-page {
            background: #f7f8fa;
        }

        .numselect {
            font-size: 16px;
            font-weight: 600;

        }

        .countnum {
            font-size: 16px;
            font-weight: 600;
            color: #00000080;
        }

        .cart-title {
            font-weight: 700;
            font-size: 24px;
        }

        .cart-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .cart-thumb {
            width: 96px;
            height: 96px;
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #fff;
        }

        .cart-thumb img {
            max-width: 88px;
            max-height: 88px;
            object-fit: contain;
        }

        .cart-product-name {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .cart-unit-price,
        .cart-item-total-text {
            font-weight: 700;
        }

        .cart-qty-form {
            background: #f3f4f6;
            border-radius: 999px;
            overflow: hidden;
        }

        .qty-btn {
            width: 34px;
            height: 34px;
            border: 0;
            background: transparent;
            font-size: 18px;
        }

        .qty-input {
            width: 70px;
            border: 0;
            background: transparent;
            text-align: center;
            outline: none;
        }

        .cart-detail-link {
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 14px;
        }

        .cart-delete-btn {
            border: 0;
            background: transparent;
            padding: 4px;
            line-height: 1;
        }

        .cart-delete-btn img {
            width: 24px;
            height: 24px;
            display: block;
            object-fit: contain;
        }

        .cart-icon-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            line-height: 1;
        }

        .cart-icon-link img {
            width: 24px;
            height: 24px;
            display: block;
            object-fit: contain;
        }

        .cart-detail-box {
            background: #f9fafb;
            border-radius: 10px;
            padding: 14px;
            font-size: 14px;
        }

        .cart-summary {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
            position: sticky;
            top: 100px;
        }

        .cart-summary-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .summary-line,
        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #ececec;
        }

        .summary-total {
            margin-top: 10px;
            font-size: 22px;
            font-weight: 700;
            border-bottom: 0;
        }

        .cart-tip-box {
            background: #f1f7ff;
            color: #2457a6;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            margin-top: 14px;
        }

        .cart-checkout-btn {
            border-radius: 999px;
            padding: 12px;
            font-weight: 700;
            background-color: #0F65BE;
        }

        @media (max-width: 991.98px) {
            .cart-summary {
                position: static;
            }
        }

        .cart-detail-box {
            margin-top: 20px;
            padding-left: 0;
            background: transparent;
        }

        .cart-detail-row {
            padding: 14px 0;
            border-top: 1px solid #e9e9e9;
        }

        .cart-detail-row:first-child {
            margin-top: 10px;
        }

        .cart-detail-label {
            font-size: 18px;
            color: #707070;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .cart-detail-value {
            font-size: 17px;
            color: #4d4d4d;
            font-weight: 600;
        }

        .cart-detail-text {
            line-height: 1.7;
        }

        .cart-color-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 14px;
        }

        .cart-color-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            color: #5a5a5a;
            font-weight: 600;
        }

        .cart-color-dot {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 1px solid #d8d8d8;
            flex-shrink: 0;
        }

        .toggle-detail-btn,
        .cart-detail-link {
            color: #2f63d7;
            font-weight: 500;
            text-decoration: none;
        }

        .cart-detail-box {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            margin-top: 0;
            padding-top: 0;
            transition:
                max-height 0.35s ease,
                opacity 0.25s ease,
                margin-top 0.25s ease,
                padding-top 0.25s ease;
        }

        .cart-detail-box.is-open {
            max-height: 1200px;
            opacity: 1;
            margin-top: 20px;
            padding-top: 4px;
        }

        .cart-detail-row {
            padding: 14px 0;
            border-top: 1px solid #e9e9e9;
        }

        .cart-detail-label {
            font-size: 18px;
            color: #707070;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .cart-detail-value {
            font-size: 17px;
            color: #4d4d4d;
            font-weight: 600;
        }

        .cart-color-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 14px;
        }

        .cart-color-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            color: #5a5a5a;
            font-weight: 600;
        }

        .cart-color-dot {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 1px solid #d8d8d8;
            flex-shrink: 0;
        }

        .cart-detail-link {
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .cart-detail-link:hover {
            color: #1746a2;
        }

        .cart-detail-link .detail-arrow {
            display: inline-block;
            transition: transform 0.25s ease;
        }

        .cart-detail-link.is-open .detail-arrow {
            transform: rotate(180deg);
        }

        .cart-product-info {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .cart-product-name {
            margin-bottom: 10px;
        }

        .cart-qty-inline {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 6px;
        }

        .cart-qty-inline span {
            font-size: 14px;
            color: #111;
        }

        .cart-qty-form {
            background: #f3f4f6;
            border-radius: 999px;
            overflow: hidden;
            height: 30px;
        }

        .qty-btn {
            width: 34px;
            height: 30px;
            border: 0;
            background: transparent;
            font-size: 14px;
            line-height: 1;
        }

        .qty-input {
            width: 54px;
            height: 30px;
            border: 0;
            background: transparent;
            text-align: center;
            outline: none;
            font-size: 14px;
        }

        .empty-cart-wrapper {
            min-height: 520px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .empty-cart-illustration {
            width: 170px;
            height: 170px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-cart-illustration img {
            width: 170px;
            height: 170px;
            display: block;
            object-fit: contain;
        }

        .empty-cart-text {
            font-size: 14px;
            font-weight: 700;
            color: #111;
            margin-bottom: 18px;
        }

        .empty-cart-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 118px;
            height: 40px;
            padding: 0 22px;
            border-radius: 8px;
            background: #2f6fc2;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .empty-cart-btn:hover {
            background: #255fac;
            color: #fff;
        }

        @media (max-width: 768px) {
            .cart-summary-title {
                font-size: 16px;

            }

            .summary-total {
                font-size: 16px;
            }

            .cart-checkout-btn {
                padding: 6px 12px;
            }

            .btn-outline-secondary {

                border-radius: 50px;
            }

            .cart-product-name {
                font-size: 14px;

            }

            .cart-icon-link img {
                width: 18px;

            }

            .cart-delete-btn img {
                width: 15px;

            }
        }
    </style>
@endsection
@section('content')
    @php
        $cartItems = collect($cart);

        $totalItems = $cartItems->count();
        $totalQty = $cartItems->sum(fn($item) => (int) ($item['quantity'] ?? 0));
        $subtotal = $cartItems->sum(fn($item) => (float) ($item['item_total'] ?? 0));

        $shipping = $subtotal > 10000 ? 0 : ($totalItems > 0 ? 800 : 0);
        $estimatedTax = $totalItems > 0 ? 20 : 0;
        $grandTotal = $subtotal + $shipping + $estimatedTax;
    @endphp
    <div class="cart-page py-4">
        <div class="container">

            <h2 class="cart-title mb-3">Carrinho</h2>

            @if ($cartItems->isEmpty())
                <div class="empty-cart-wrapper">
                    <div class="empty-cart-illustration">
                        <img src="{{ asset('assets/images/icon/emtry-cart.png') }}" alt="Empty cart">
                    </div>

                    <div class="empty-cart-text">
                        Your cart is empty
                    </div>

                    <a href="{{ route('products.index') }}" class="empty-cart-btn">
                        Go Shopping
                    </a>
                </div>
            @else
                <div class="row g-4">
                    {{-- LEFT cart items --}}
                    <div class="col-lg-8">
                        <div class="cart-left">


                            {{-- @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif --}}

                            @if ($cartItems->count())
                                <div class="cart-select-all mb-3">
                                    <label class="d-flex align-items-center gap-2">
                                        <input type="checkbox" id="selectAllCart" checked>
                                        <span class="numselect">{!! __('product.cart.select_all') !!} <span
                                                class="countnum">({{ $cartItems->count() }})</span></span>
                                    </label>
                                </div>

                                <div id="cartItemsWrap">
                                    @foreach ($cartItems as $item)
                                        @php
                                            $cartItemId = $item['cart_item_id'];
                                            $productName = $item['product_name'] ?? '-';
                                            $productImage = $item['product_image'] ?? null;
                                            $quantity = (int) ($item['quantity'] ?? 1);
                                            $unitPrice = (float) ($item['unit_price'] ?? ($item['base_price'] ?? 0));
                                            $itemTotal = (float) ($item['item_total'] ?? $unitPrice * $quantity);
                                            $displayUnitPrice = $quantity > 0 ? $itemTotal / $quantity : 0;
                                            $options = $item['options'] ?? [];
                                            $customColors = $item['custom_colors'] ?? [];

                                            $qtyRuleType = null;
                                            $minQty = 1;
                                            $maxQty = null;
                                            $exactQty = null;
                                            $qtyRuleMessage = null;

                                            foreach ($options as $opt) {
                                                $ruleType = $opt['qty_rule_type'] ?? null;

                                                if (!$ruleType) {
                                                    continue;
                                                }

                                                if ($ruleType === 'exact' && !empty($opt['exact_qty'])) {
                                                    $qtyRuleType = 'exact';
                                                    $exactQty = (int) $opt['exact_qty'];
                                                    $minQty = $exactQty;
                                                    $maxQty = $exactQty;
                                                    $qtyRuleMessage = 'Quantity fixed at ' . $exactQty . ' pcs.';
                                                    break;
                                                }

                                                if ($ruleType === 'range') {
                                                    $qtyRuleType = 'range';

                                                    if (!empty($opt['min_qty'])) {
                                                        $minQty = max($minQty, (int) $opt['min_qty']);
                                                    }

                                                    if (!empty($opt['max_qty'])) {
                                                        $maxQty = $maxQty
                                                            ? min($maxQty, (int) $opt['max_qty'])
                                                            : (int) $opt['max_qty'];
                                                    }

                                                    $qtyRuleMessage =
                                                        'Quantity must be between ' .
                                                        $minQty .
                                                        ' - ' .
                                                        $maxQty .
                                                        ' pcs.';
                                                }

                                                if ($ruleType === 'min' && !empty($opt['min_qty'])) {
                                                    $qtyRuleType = 'min';
                                                    $minQty = max($minQty, (int) $opt['min_qty']);
                                                    $qtyRuleMessage = 'Minimum quantity is ' . $minQty . ' pcs.';
                                                }

                                                if ($ruleType === 'max' && !empty($opt['max_qty'])) {
                                                    $qtyRuleType = 'max';
                                                    $maxQty = $maxQty
                                                        ? min($maxQty, (int) $opt['max_qty'])
                                                        : (int) $opt['max_qty'];

                                                    $qtyRuleMessage = 'Maximum quantity is ' . $maxQty . ' pcs.';
                                                }
                                            }
                                        @endphp

                                        <div class="cart-card mb-3" data-cart-item-id="{{ $cartItemId }}"
                                            data-quantity="{{ $quantity }}" data-item-total="{{ $itemTotal }}">

                                            <div class="row g-3 align-items-start">
                                                <div class="col-auto">
                                                    <div class="cart-check-wrap">
                                                        <input type="checkbox" class="cart-item-checkbox" checked
                                                            data-item-total="{{ $itemTotal }}"
                                                            data-quantity="{{ $quantity }}">
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="cart-thumb">
                                                        @if ($productImage)
                                                            <img src="{{ asset('storage/' . $productImage) }}"
                                                                alt="{{ $productName }}">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="cart-card-main">
                                                        <div
                                                            class="cart-card-top d-flex justify-content-between gap-3 flex-wrap">
                                                            <div class="cart-product-info">
                                                                <div class="cart-category small text-muted">
                                                                    Cordão
                                                                </div>

                                                                <h4 class="cart-product-name">
                                                                    {{ $productName }}
                                                                </h4>

                                                                <div class="cart-qty-inline">
                                                                    <span>Qtd:</span>

                                                                    <form action="{{ route('cart.updateQuantity') }}"
                                                                        method="POST"
                                                                        class="cart-qty-form d-flex align-items-center">
                                                                        @csrf

                                                                        <input type="hidden" name="cart_item_id"
                                                                            value="{{ $cartItemId }}">

                                                                        <button type="button" class="qty-btn qty-minus"
                                                                            {{ $quantity <= $minQty || $qtyRuleType === 'exact' ? 'disabled' : '' }}>
                                                                            -
                                                                        </button>

                                                                        <input type="number" name="quantity"
                                                                            class="qty-input" value="{{ $quantity }}"
                                                                            min="{{ $minQty }}"
                                                                            @if ($maxQty) max="{{ $maxQty }}" @endif
                                                                            data-min="{{ $minQty }}"
                                                                            data-max="{{ $maxQty ?? '' }}"
                                                                            data-exact="{{ $exactQty ?? '' }}"
                                                                            {{ $qtyRuleType === 'exact' ? 'readonly' : '' }}>

                                                                        <button type="button" class="qty-btn qty-plus"
                                                                            {{ ($maxQty && $quantity >= $maxQty) || $qtyRuleType === 'exact' ? 'disabled' : '' }}>
                                                                            +
                                                                        </button>
                                                                    </form>
                                                                    @if ($qtyRuleMessage)
                                                                        <div class="small text-danger mt-1">
                                                                            {{ $qtyRuleMessage }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="cart-price-info text-end">
                                                                <div class="small text-muted">{!! __('product.cart.unit_price') !!}</div>
                                                                <div class="cart-unit-price">¥
                                                                    {{ number_format($displayUnitPrice, 2) }} /un</div>

                                                                <div class="small text-muted mt-2">{!! __('product.cart.total_item') !!}
                                                                </div>
                                                                <div class="cart-item-total-text">¥
                                                                    {{ number_format($itemTotal, 2) }}</div>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="cart-card-bottom d-flex justify-content-between align-items-end gap-3 flex-wrap mt-3">
                                                            <div>


                                                                <div class="cart-actions d-flex align-items-center gap-2">
                                                                    <a href="{{ route('cart.edit', $cartItemId) }}"
                                                                        class="cart-icon-link" aria-label="Edit">
                                                                        <img src="{{ asset('assets/images/icon/edit-icon.png') }}"
                                                                            alt="">
                                                                    </a>

                                                                    <form action="{{ route('cart.remove') }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="cart_item_id"
                                                                            value="{{ $cartItemId }}">
                                                                        <button type="submit" class="cart-delete-btn"
                                                                            aria-label="Delete">
                                                                            <img src="{{ asset('assets/images/icon/delete-icon.png') }}"
                                                                                alt="">
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <button type="button"
                                                                    class="cart-detail-link toggle-detail-btn"
                                                                    data-target="#detail-{{ $loop->index }}">
                                                                    Details
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @php
                                                            $groupedOptions = collect($options)->groupBy('group_name');
                                                        @endphp

                                                        <div class="cart-detail-box mt-3" id="detail-{{ $loop->index }}">

                                                            @foreach ($groupedOptions as $groupName => $groupItems)
                                                                @php
                                                                    $hasRealColorCode = collect($groupItems)->contains(
                                                                        function ($opt) {
                                                                            return !empty($opt['color_code']) ||
                                                                                !empty($opt['variant_color_code']);
                                                                        },
                                                                    );
                                                                @endphp

                                                                <div class="cart-detail-row">
                                                                    <div class="cart-detail-label">
                                                                        {{ $groupName }}
                                                                    </div>

                                                                    <div class="cart-detail-value">
                                                                        @if ($hasRealColorCode)
                                                                            <div class="cart-color-list">
                                                                                @foreach ($groupItems as $opt)
                                                                                    @php
                                                                                        $dotColor =
                                                                                            $opt['color_code'] ??
                                                                                            ($opt[
                                                                                                'variant_color_code'
                                                                                            ] ??
                                                                                                null);
                                                                                    @endphp

                                                                                    <div class="cart-color-item">
                                                                                        @if ($dotColor)
                                                                                            <span class="cart-color-dot"
                                                                                                style="background: {{ $dotColor }};">
                                                                                            </span>
                                                                                        @endif

                                                                                        <span>
                                                                                            {{ $opt['option_name'] ?? '-' }}
                                                                                            @if (!empty($opt['variant_name']))
                                                                                                -
                                                                                                {{ $opt['variant_name'] }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @else
                                                                            @foreach ($groupItems as $opt)
                                                                                <div class="cart-detail-text">
                                                                                    {{ $opt['option_name'] ?? '-' }}
                                                                                    @if (!empty($opt['variant_name']))
                                                                                        - {{ $opt['variant_name'] }}
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            @if (!empty($customColors))
                                                                <div class="cart-detail-row">
                                                                    <div class="cart-detail-label">
                                                                        Cor do Cordão:
                                                                    </div>

                                                                    <div class="cart-detail-value">
                                                                        <div class="cart-color-list">
                                                                            @foreach ($customColors as $color)
                                                                                <div class="cart-color-item">
                                                                                    <span class="cart-color-dot"
                                                                                        style="background:#5b9b4c;"></span>
                                                                                    <span>{{ $color['value'] ?? '-' }}</span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Your cart is empty.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT summary --}}
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3 class="cart-summary-title">{!! __('product.cart.checkout') !!}</h3>
                            <div class="small fw-semibold mb-3">{!! __('product.cart.summary') !!}</div>

                            <div class="summary-line">
                                <span>{!! __('product.cart.items') !!} :</span>
                                <strong><span id="summaryItems">{{ $totalItems }}</span>
                                    {!! __('product.cart.products') !!}</strong>
                            </div>

                            <div class="summary-line">
                                <span>{!! __('product.cart.quantity_total') !!} :</span>
                                <strong><span id="summaryQty">{{ $totalQty }}</span> {!! __('product.cart.unit') !!}</strong>
                            </div>

                            <div class="summary-line">
                                <span>{!! __('product.cart.subtotal') !!} :</span>
                                <strong>¥ <span id="summarySubtotal">{{ number_format($subtotal, 2) }}</span></strong>
                            </div>

                            <div class="summary-line">
                                <span>{!! __('product.cart.shipping') !!} :</span>
                                <strong>¥ <span id="summaryShipping">{{ number_format($shipping, 2) }}</span></strong>
                            </div>

                            <div class="summary-line">
                                <span>{!! __('product.cart.tax') !!} :</span>
                                <strong>¥ <span id="summaryTax">{{ number_format($estimatedTax, 2) }}</span></strong>
                            </div>

                            <div class="summary-total">
                                <span>{!! __('product.cart.total') !!}</span>
                                <strong>¥ <span id="summaryGrandTotal">{{ number_format($grandTotal, 2) }}</span></strong>
                            </div>

                            <div class="cart-tip-box">
                                💡 {!! __('product.cart.tip') !!}
                            </div>

                            <div class="coupon-box mt-3">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('product.cart.coupon') }}" aria-label="Coupon code">
                                    <button class="btn btn-primary" type="button">›</button>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ auth()->check() ? route('checkout.index') : route('checkout.authChoice') }}"
                                    class="btn btn-primary cart-checkout-btn">
                                    {!! __('product.cart.checkout') !!}
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    {!! __('product.cart.continue_shopping') !!}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection



@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAllCart');
            const itemCheckboxes = document.querySelectorAll('.cart-item-checkbox');

            function formatNumber(value) {
                return Number(value || 0).toFixed(2);
            }

            function updateSummary() {
                let selectedItems = 0;
                let selectedQty = 0;
                let subtotal = 0;

                document.querySelectorAll('.cart-card').forEach(function(card) {
                    const checkbox = card.querySelector('.cart-item-checkbox');

                    if (checkbox && checkbox.checked) {
                        selectedItems++;
                        selectedQty += parseInt(card.dataset.quantity || 0);
                        subtotal += parseFloat(card.dataset.itemTotal || 0);
                    }
                });

                const shipping = subtotal > 11000 ? 0 : (selectedItems > 0 ? 800 : 0);
                const tax = subtotal * 0.10;
                const grandTotal = subtotal + shipping + tax;

                document.getElementById('summaryItems').innerText = selectedItems;
                document.getElementById('summaryQty').innerText = selectedQty;
                document.getElementById('summarySubtotal').innerText = formatNumber(subtotal);
                document.getElementById('summaryShipping').innerText = formatNumber(shipping);
                document.getElementById('summaryTax').innerText = formatNumber(tax);
                document.getElementById('summaryGrandTotal').innerText = formatNumber(grandTotal);
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    itemCheckboxes.forEach(function(item) {
                        item.checked = selectAll.checked;
                    });
                    updateSummary();
                });
            }

            itemCheckboxes.forEach(function(item) {
                item.addEventListener('change', function() {
                    const allChecked = [...itemCheckboxes].every(cb => cb.checked);
                    if (selectAll) {
                        selectAll.checked = allChecked;
                    }
                    updateSummary();
                });
            });

            document.querySelectorAll('.toggle-detail-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const target = document.querySelector(this.dataset.target);

                    if (!target) {
                        return;
                    }

                    const isAlreadyOpen = target.classList.contains('is-open');

                    document.querySelectorAll('.cart-detail-box').forEach(function(box) {
                        box.classList.remove('is-open');
                    });

                    document.querySelectorAll('.toggle-detail-btn').forEach(function(btn) {
                        btn.classList.remove('is-open');

                        const text = btn.querySelector('.detail-text');
                        if (text) {
                            text.textContent = 'Details';
                        }
                    });

                    if (!isAlreadyOpen) {
                        target.classList.add('is-open');
                        this.classList.add('is-open');

                        const text = this.querySelector('.detail-text');
                        if (text) {
                            text.textContent = 'Hide Details';
                        }
                    }
                });
            });

            document.querySelectorAll('.cart-qty-form').forEach(function(form) {
                const minusBtn = form.querySelector('.qty-minus');
                const plusBtn = form.querySelector('.qty-plus');
                const input = form.querySelector('.qty-input');

                if (!input) {
                    return;
                }

                function getMin() {
                    return parseInt(input.dataset.min || input.min || 1);
                }

                function getMax() {
                    return input.dataset.max ? parseInt(input.dataset.max) : null;
                }

                function getExact() {
                    return input.dataset.exact ? parseInt(input.dataset.exact) : null;
                }

                function updateButtons() {
                    const value = parseInt(input.value || 0);
                    const min = getMin();
                    const max = getMax();
                    const exact = getExact();

                    if (minusBtn) {
                        minusBtn.disabled = !!exact || value <= min;
                    }

                    if (plusBtn) {
                        plusBtn.disabled = !!exact || (max !== null && value >= max);
                    }
                }

                if (minusBtn) {
                    minusBtn.addEventListener('click', function() {
                        const min = getMin();
                        const exact = getExact();

                        if (exact) {
                            input.value = exact;
                            updateButtons();
                            return;
                        }

                        let value = parseInt(input.value || min);
                        value = Math.max(min, value - 1);

                        input.value = value;
                        updateButtons();
                        form.submit();
                    });
                }

                if (plusBtn) {
                    plusBtn.addEventListener('click', function() {
                        const max = getMax();
                        const exact = getExact();

                        if (exact) {
                            input.value = exact;
                            updateButtons();
                            return;
                        }

                        let value = parseInt(input.value || getMin());

                        if (max !== null && value >= max) {
                            input.value = max;
                            updateButtons();
                            return;
                        }

                        value = value + 1;

                        if (max !== null && value > max) {
                            value = max;
                        }

                        input.value = value;
                        updateButtons();
                        form.submit();
                    });
                }

                input.addEventListener('change', function() {
                    const min = getMin();
                    const max = getMax();
                    const exact = getExact();

                    let value = parseInt(input.value || min);

                    if (exact) {
                        value = exact;
                    }

                    if (value < min) {
                        value = min;
                    }

                    if (max !== null && value > max) {
                        value = max;
                    }

                    input.value = value;
                    updateButtons();
                    form.submit();
                });

                updateButtons();
            });

            updateSummary();
        });
    </script>
@endsection
