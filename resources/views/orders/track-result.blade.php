@extends('layouts.app')

@section('title', 'Track Order Result')

@section('css')
    <style>
        .tracking-page {
            background: #f1f1f1;
            padding: 20px 16px 60px;
        }

        .tracking-container {
            max-width: 85%;
            margin: 0 auto;
            background: #fff;
            border-radius: 4px;
            padding: 24px 32px 36px;
        }

        .tracking-back {
            display: inline-block;
            margin-bottom: 0;
            color: #111;
            text-decoration: none;
            font-size: 24px;
            font-weight: 600;
        }

        .tracking-back-wrap {
            max-width: 85%;
            margin: 0 auto 14px;
        }

        .tracking-top-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 18px;
            margin-bottom: 28px;
        }

        .tracking-label {
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }

        .tracking-value {
            font-size: 16px;
            color: #111;
            font-weight: 600;
        }

        .tracking-status-badge {
            display: inline-flex;
            padding: 4px 9px;
            background: #e8f0ff;
            color: #1763d1;
            border-radius: 4px;
            font-size: 12px;
            text-transform: capitalize;
        }

        .tracking-section-title {
            margin: 22px 0 24px;
            font-size: 16px;
            font-weight: 700;
            color: #111;
        }

        .progress-track {
            position: relative;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            align-items: start;
            margin: 18px 0 48px;
            padding-top: 0;
        }

        .progress-line {
            position: absolute;
            left: 10%;
            right: 10%;
            top: 56px;
            height: 4px;
            background: #e6e6e6;
            border-radius: 999px;
            z-index: 1;
        }

        .progress-line-fill {
            height: 100%;
            width: var(--progress-width);
            background: #a9c0ff;
            border-radius: 999px;
            transition: width .3s ease;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .progress-icon {
            order: 1;
            width: 42px;
            height: 42px;
            margin: 0 auto 6px;
            color: #456cf0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            line-height: 1;
        }

        .progress-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .progress-dot {
            order: 2;
            position: relative;
            width: 20px;
            height: 20px;
            margin: 0 auto 13px;
            border-radius: 50%;
            background: #fff;
            border: 5px solid #e3e3e3;
        }

        .progress-step.is-done .progress-dot {
            background: #456cf0;
            border-color: #456cf0;
        }

        .progress-step.is-done .progress-dot::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            width: 5px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: translate(-50%, -58%) rotate(45deg);
        }

        .progress-step.is-active .progress-dot {
            background: #fff;
            border-color: #456cf0;
        }

        .progress-title {
            order: 3;
            font-size: 16px;
            font-weight: 700;
            color: #111;
            line-height: 1.2;
        }

        .progress-date {
            order: 4;
            margin-top: 5px;
            font-size: 11px;
            color: #555;
        }

        .tracking-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            margin: 40px 0 56px;
        }

        .tracking-info h3 {
            margin: 0 0 18px;
            font-size: 24px;
            color: #111;
        }

        .tracking-info-block {
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.55;
        }

        .tracking-info-block strong {
            display: block;
            margin-bottom: 4px;
        }

        .summary-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .summary-row strong {
            font-weight: 700;
        }

        .items-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .order-items-table {
            width: 100%;
            background: #f3f6fb;
            display: grid;
            grid-template-columns: minmax(280px, 1fr) 35% 10% 12%;
            align-items: center;
            gap: 18px;
            padding: 14px 16px;
            font-size: 12px;
            font-weight: 600;
            color: #111;
        }

        .order-item-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 12px;
            padding: 16px;
            display: grid;
            grid-template-columns: 90px minmax(172px, 1fr) 35% 10% 11%;
            align-items: center;
            gap: 18px;
        }

        .order-item-product {
            display: contents;
        }

        .order-item-img {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 8px;
            object-fit: contain;
            background: #fff;
        }

        .item-type {
            font-size: 12px;
            color: #777;
        }

        .item-name {
            font-size: 15px;
            font-weight: 700;
            color: #111;
            margin: 4px 0;
        }

        .item-detail {
            font-size: 12px;
            color: #555;
            line-height: 1.45;
        }

        .buy-again-btn {
            display: inline-flex;
            justify-content: center;
            padding: 7px 18px;
            border-radius: 6px;
            background: #2f6fc7;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .tracking-container {
                padding: 20px 16px 30px;
            }

            .tracking-top-grid,
            .tracking-info-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .progress-track {
                display: flex !important;
                gap: 0 !important;
                overflow-x: auto !important;
                padding-bottom: 24px !important;
                -webkit-overflow-scrolling: touch !important;
            }

            .progress-track::-webkit-scrollbar {
                height: 5px;
            }

            .progress-track::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .progress-track::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 999px;
            }

            .progress-step {
                flex: 0 0 135px !important;
                min-width: 135px !important;
            }

            .progress-line {
                left: 67.5px !important;
                right: 67.5px !important;
                width: calc(100% - 135px) !important;
                top: 56px !important;
            }

            .progress-title {
                font-size: 13px !important;
            }

            .progress-date {
                font-size: 11px !important;
                white-space: nowrap !important;
            }

            .order-items-table,
            .order-item-card {
                grid-template-columns: 80px 1fr;
            }

            .order-items-table {
                display: none;
            }

            .order-item-card>div:nth-child(n+3) {
                grid-column: 1 / -1;
            }
        }

        .item-detail-toggle {
            border: 0;
            background: transparent;
            color: #1d5bd8;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .item-detail-toggle-icon {
            /* width: 12px;
                                            height: 12px; */
            object-fit: contain;
            transition: transform .2s ease;
        }

        .order-item-card.is-open .item-detail-toggle-icon {
            transform: rotate(180deg);
        }

        .item-options-detail {
            grid-column: 2 / -1;
            display: none;
            margin-top: -8px;
            padding-bottom: 4px;
        }

        .order-item-card.is-open .item-options-detail {
            display: block;
        }

        .item-option-row {
            margin-bottom: 14px;
            font-size: 15px;
            line-height: 1.45;
        }

        .item-option-label {
            color: #888;
            margin-right: 4px;
        }

        .item-option-value {
            color: #111;
            font-weight: 500;
        }

        @media (max-width: 900px) {
            .item-options-detail {
                grid-column: 1 / -1;
                margin-top: 0;
            }
        }

        .download-receipt-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .download-receipt-btn {
            min-width: 170px;
            height: 34px;
            border: 1px solid #2f6fc7;
            border-radius: 6px;
            background: #fff;
            color: #2f6fc7;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
        }

        .download-receipt-btn:hover {
            background: #2f6fc7;
            color: #fff;
        }
    </style>
@endsection

@section('content')

    @php
        $status = $order->order_status ?? 'order_pending';

        $steps = [
            'order_pending' => [
                'label' => __('track_order.track_detail.order'),
                'icon' =>
                    '<img src="' .
                    asset('assets/images/icon/solar_box-bold-duotone.png') .
                    '" alt="" class="img-fluid">',
            ],
            'design_in_progress' => [
                'label' => __('track_order.track_detail.design_approve'),
                'icon' =>
                    '<img src="' . asset('assets/images/icon/clarity_design-solid.png') . '" alt="" class="img-fluid">',
            ],
            'production' => [
                'label' => __('track_order.track_detail.production'),
                'icon' =>
                    '<img src="' .
                    asset('assets/images/icon/flat-color-icons_factory.png') .
                    '" alt="" class="img-fluid">',
            ],
            'delivery' => [
                'label' => __('track_order.track_detail.delivery'),
                'icon' => '<img src="' . asset('assets/images/icon/delivery.png') . '" alt="" class="img-fluid">',
            ],
            'delivered' => [
                'label' => __('track_order.track_detail.shipped'),
                'icon' =>
                    '<img src="' .
                    asset('assets/images/icon/solar_box-bold-duotone.png') .
                    '" alt="" class="img-fluid">',
            ],
        ];

        $statusMap = [
            'order_pending' => 0,
            'design_in_progress' => 1,
            'production' => 2,
            'delivery' => 3,
            'delivered' => 4,
            'completed' => 4,
            'cancelled' => 0,
        ];

        $currentStep = $statusMap[$status] ?? 0;
        $progressWidth = ($currentStep / 4) * 100;
    @endphp

    <section class="tracking-page">
        <div class="tracking-back-wrap">
            <a href="{{ route('track-order.index') }}" class="tracking-back"><img
                    src="{{ asset('assets/images/icon/Vector (9).png') }}" alt=""> Track Order</a>

        </div>

        <div class="tracking-container">
            <div class="tracking-top-grid">
                <div>
                    <div class="tracking-label">{{ __('track_order.track_detail.order_number') }}</div>
                    <div class="tracking-value">{{ $order->order_no }}</div>
                </div>

                <div>
                    <div class="tracking-label">{{ __('track_order.track_detail.data') }}</div>
                    <div class="tracking-value">{{ $order->created_at?->format('d-m-Y') }}</div>
                </div>

                <div>
                    <div class="tracking-label">{{ __('track_order.track_detail.number_of_items') }}</div>
                    <div class="tracking-value">{{ $order->items->count() }} Items</div>
                </div>

                <div>
                    <div class="tracking-label">{{ __('track_order.track_detail.status') }}</div>
                    <div class="tracking-status-badge">
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </div>
                </div>
            </div>

            <div class="tracking-section-title">{{ __('track_order.track_detail.order_track_result') }}</div>

            <div class="progress-track" style="--progress-width: {{ $progressWidth }}%;">
                <div class="progress-line">
                    <div class="progress-line-fill"></div>
                </div>

                @foreach ($steps as $stepKey => $step)
                    @php
                        $stepIndex = array_search($stepKey, array_keys($steps));
                        $stepClass =
                            $stepIndex < $currentStep ? 'is-done' : ($stepIndex === $currentStep ? 'is-active' : '');
                    @endphp

                    <div class="progress-step {{ $stepClass }}">
                        <div class="progress-icon">{!! $step['icon'] !!}</div>
                        <div class="progress-dot"></div>
                        <div class="progress-title">{{ $step['label'] }}</div>

                        @if ($stepIndex <= $currentStep)
                            <div class="progress-date">
                                {{ $order->updated_at?->format('d-m-Y H:i') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="tracking-info-grid">
                <div class="tracking-info">
                    <h3>{{ __('track_order.track_detail.customer_information') }}</h3>

                    <div class="tracking-info-block">
                        <strong>{{ __('track_order.track_detail.contact') }}</strong>
                        {{ $order->customer->personal_first_name ?? '-' }}
                        {{ $order->customer->personal_last_name ?? '' }}<br>
                        {{ $order->customer->personal_email ?? '-' }}<br>
                        {{ $order->customer->personal_phone ?? '-' }}
                    </div>

                    <div class="tracking-info-block">
                        <strong>{{ __('track_order.track_detail.shipping_address') }}</strong>
                        {{ $order->customer->shipping_first_name ?? '' }}
                        {{ $order->customer->shipping_last_name ?? '' }}<br>
                        {{ $order->customer->shipping_postcode ?? '' }}<br>
                        {{ $order->customer->shipping_area ?? '' }}<br>
                        {{ $order->customer->shipping_city ?? '' }},
                        {{ $order->customer->shipping_province ?? '' }}
                    </div>

                    <div class="tracking-info-block">
                        <strong>{{ __('track_order.track_detail.billing_address') }}</strong>
                        {{ $order->customer->billing_first_name ?? '' }}
                        {{ $order->customer->billing_last_name ?? '' }}<br>
                        {{ $order->customer->billing_postcode ?? '' }}<br>
                        {{ $order->customer->billing_area ?? '' }}<br>
                        {{ $order->customer->billing_city ?? '' }},
                        {{ $order->customer->billing_province ?? '' }}
                    </div>
                </div>

                <div class="tracking-info">
                    <h3>{{ __('track_order.track_detail.order_summary') }}</h3>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.order_subtotal') }}</span>
                        <strong>Â¥{{ number_format($order->subtotal ?? 0, 0) }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.discount') }}</span>
                        <strong>-Â¥{{ number_format($order->discount_amount ?? 0, 0) }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.shipping') }}</span>
                        <strong>Â¥{{ number_format($order->shipping_fee ?? 0, 0) }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.total_order') }}</span>
                        <strong>Â¥{{ number_format($order->grand_total ?? 0, 0) }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.name') }}</span>
                        <strong>
                            {{ $order->customer->personal_first_name ?? '-' }}
                            {{ $order->customer->personal_last_name ?? '' }}
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.payment_method') }}</span>
                        <strong>{{ $order->payment->payment_method ?? '-' }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.payment_status') }}</span>
                        <strong>{{ ucfirst($order->payment_status ?? 'pending') }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>{{ __('track_order.track_detail.order_status') }}</span>
                        <strong>{{ ucwords(str_replace('_', ' ', $order->order_status ?? 'order_pending')) }}</strong>
                    </div>
                </div>
            </div>

            <div class="items-title">{{ __('track_order.track_detail.items') }}</div>

            <div class="order-items-table">
                <div>{{ __('track_order.track_detail.product') }}</div>
                <div>{{ __('track_order.track_detail.quantity') }}</div>
                <div>{{ __('track_order.track_detail.total_price') }}</div>
                <div></div>
            </div>

            @foreach ($order->items as $item)
                @php
                    $options = is_array($item->options) ? $item->options : json_decode($item->options ?? '[]', true);

                    // $sizeText = collect($options)
                    //     ->filter(fn($opt) => str_contains(strtolower($opt['group_name'] ?? ''), 'Largura do Cordão'))
                    //     ->pluck('option_name')
                    //     ->implode(', ');

                    $itemTotal = $item->item_total ?? ($item->qty ?? ($item->quantity ?? 0)) * ($item->unit_price ?? 0);
                @endphp

                <div class="order-item-card">
                    <div class="order-item-product">
                        <div>
                            @if ($item->product_image)
                                <img src="{{ asset('storage/' . $item->product_image) }}" class="order-item-img">
                            @else
                                <div class="order-item-img"></div>
                            @endif
                        </div>

                        <div>
                            <div class="item-type">
                                {{ $item->product_type_name ?? 'Product' }}
                            </div>

                            <div class="item-name">
                                {{ $item->product_name_snapshot ?? $item->product_name }}
                            </div>

                            {{-- <div class="item-detail">
                                Sub-Order Number: {{ $item->sub_order_no ?? $order->order_no }}<br>
                                Size: {{ $sizeText ?: '-' }}
                            </div> --}}
                        </div>
                    </div>

                    <div>
                        {{ $item->qty ?? $item->quantity }}
                    </div>

                    <div>
                        <strong>¥{{ number_format($itemTotal, 2) }}</strong>
                    </div>

                    <div>
                        @if (!empty($item->product_id) && !empty($item->product))
                            <a href="{{ route('products.description', $item->product->product_code) }}" class="buy-again-btn">
                                {{ __('track_order.track_detail.buy_again') }}
                            </a>
                        @else
                            <a href="{{ route('products.index') }}" class="buy-again-btn">
                                {{ __('track_order.track_detail.buy_again') }}
                            </a>
                        @endif

                        @if (!empty($options))
                            <button type="button" class="item-detail-toggle">
                                <img src="{{ asset('assets/images/icon/weui_arrow-filled.png') }}" alt=""
                                    class="item-detail-toggle-icon">
                                <span class="item-detail-toggle-text">{{ __('track_order.track_detail.details') }}</span>
                            </button>
                        @endif
                    </div>

                    @if (!empty($options))
                        <div class="item-options-detail">
                            @foreach ($options as $option)
                                <div class="item-option-row">
                                    <span class="item-option-label">
                                        {{ $option['group_name'] ?? '-' }}:
                                    </span>

                                    <span class="item-option-value">
                                        {{ $option['option_name'] ?? '-' }}

                                        @if (!empty($option['variant_name']))
                                            {{ $option['variant_name'] }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="download-receipt-wrap">
                <a href="{{ route('track-order.receipt', $order->order_id) }}" class="download-receipt-btn">
                    ⭳ {{ __('track_order.track_detail.download_receipt') }}
                </a>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.item-detail-toggle').forEach(function(button) {
                button.addEventListener('click', function() {
                    const card = this.closest('.order-item-card');
                    const text = this.querySelector('.item-detail-toggle-text');

                    if (!card) return;

                    const isOpen = card.classList.toggle('is-open');


                    if (text) {
                        text.textContent = isOpen ? 'Details' : 'Details';
                    }
                });
            });
        });
    </script>
@endsection
