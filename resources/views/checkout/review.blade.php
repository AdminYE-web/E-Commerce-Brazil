@extends('layouts.app')

@section('title', 'Checkout Review')

@section('css')
    <style>
        .checkout-page {
            background: #f5f6f8;
            padding: 30px 0 60px;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 28px;
            align-items: start;
        }

        .review-card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            margin-bottom: 18px;
            overflow: hidden;
        }

        .review-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .review-card-title {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .review-edit-link {
            color: #2563eb;
            font-size: 12px;
            text-decoration: none;
        }

        .review-body {
            padding: 18px;
        }

        .review-item {
            display: grid;
            grid-template-columns: 90px 1fr 130px;
            gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .review-item:last-child {
            border-bottom: 0;
        }

        .review-product-image {
            width: 78px;
            height: 78px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .review-product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .review-product-category {
            color: #64748b;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .review-product-name {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .review-product-qty {
            font-size: 13px;
        }

        .review-price-box {
            text-align: right;
            font-size: 12px;
        }

        .review-price-box strong {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .review-detail-link {
            color: #2563eb;
            font-size: 12px;
            text-decoration: none;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 12px;
            font-size: 13px;
            line-height: 1.6;
        }

        .info-label {
            color: #111;
            font-weight: 700;
        }

        .info-value {
            color: #111;
        }

        .payment-method-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .payment-bank-detail {
            font-size: 13px;
            line-height: 1.7;
        }

        .payment-warning {
            margin-top: 12px;
            font-size: 13px;
        }

        .payment-warning strong {
            font-weight: 800;
        }

        .checkout-stepper {
            max-width: 760px;
            margin: 0 auto 34px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
        }

        .checkout-stepper::before {
            content: "";
            position: absolute;
            top: 25px;
            left: 70px;
            right: 70px;
            height: 3px;
            background: #d9d9d9;
            z-index: 1;
        }

        .checkout-stepper::after {
            content: "";
            position: absolute;
            top: 25px;
            left: 70px;
            width: calc(((100% - 140px) / 4) * 4);
            height: 3px;
            background: #48c26b;
            z-index: 2;
        }

        .checkout-step {
            position: relative;
            z-index: 3;
            width: 120px;
            text-align: center;
        }

        .step-circle {
            width: 52px;
            height: 52px;
            margin: 0 auto 8px;
            border-radius: 50%;
            border: 2px solid #d9d9d9;
            background: #f5f6f8;
            color: #a7b1c2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 600;
        }

        .step-label {
            font-size: 15px;
            color: #9aa8bd;
            font-weight: 500;
        }

        .checkout-step.completed .step-circle {
            background: #48c26b;
            border-color: #48c26b;
            color: #fff;
            font-size: 30px;
            font-weight: 700;
        }

        .checkout-step.completed .step-label {
            color: #111;
            font-weight: 600;
        }

        .checkout-step.current .step-circle {
            background: #f5f6f8;
            border-color: #2f6fff;
            color: #2f6fff;
        }

        .checkout-step.current .step-label {
            color: #2f6fff;
            font-weight: 600;
        }

        @media (max-width: 991px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .review-item {
                grid-template-columns: 80px 1fr;
            }

            .review-price-box {
                grid-column: 1 / -1;
                text-align: left;
            }
        }

        .review-detail-link {
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .review-detail-arrow {
            width: 12px;
            height: 12px;
            object-fit: contain;
            display: inline-block;
            transition: transform 0.25s ease;
        }

        .review-detail-link.is-open .review-detail-arrow {
            transform: rotate(180deg);
        }

        .review-detail-box {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition:
                max-height 0.35s ease,
                opacity 0.25s ease,
                padding 0.25s ease;
            padding: 0 0;
            border-bottom: 1px solid #eeeeee;
        }

        .review-detail-box.is-open {
            max-height: 1200px;
            opacity: 1;
            padding: 12px 0 18px 106px;
        }

        .review-detail-row {
            padding: 10px 0;
            border-top: 1px solid #eeeeee;
        }

        .review-detail-label {
            color: #707070;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .review-detail-value {
            color: #4d4d4d;
            font-size: 14px;
            font-weight: 700;
        }

        .review-detail-text {
            line-height: 1.7;
        }

        .review-color-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 14px;
        }

        .review-color-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 14px;
            color: #555;
            font-weight: 700;
        }

        .review-color-dot {
            width: 16px;
            height: 16px;
            display: inline-block;
            border: 1px solid #d8d8d8;
            flex-shrink: 0;
        }

        @media (max-width: 991px) {
            .review-detail-box.is-open {
                padding-left: 0;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $payment = $payment ?? session('checkout_payment', []);
        $paymentMethod = $payment['payment_method'] ?? '';

        $customer = $customer ?? session('checkout_customer', []);
        $personal = $personal ?? ($customer['personal'] ?? []);
        $shippingAddress = $shippingAddress ?? ($customer['shipping'] ?? []);
        $billing = $billing ?? ($customer['billing'] ?? []);
    @endphp

    <form action="{{ route('checkout.placeOrder') }}" method="POST">
    @csrf

        <div class="checkout-page">
            <div class="container">

                @include('checkout.partials.stepper', ['currentStep' => 5])

                <div class="checkout-layout">

                    <div class="checkout-left">

                        {{-- RESUMO DE ITENS --}}
                        <div class="review-card">
                            <div class="review-card-header">
                                <div class="review-card-title">Resumo de Itens</div>
                                <a href="{{ route('cart.index') }}" class="review-edit-link">Editar</a>
                            </div>

                            <div class="review-body">
                                @foreach ($cart as $cartItemId => $item)
                                    @php
                                        $quantity = (int) ($item['quantity'] ?? 1);
                                        $unitPrice = (float) ($item['unit_price'] ?? 0);
                                        $itemTotal = (float) ($item['item_total'] ?? 0);
                                        $productImage = $item['product_image'] ?? null;
                                    @endphp

                                    <div class="review-item">
                                        <div class="review-product-image">
                                            @if ($productImage)
                                                <img src="{{ asset('storage/' . $productImage) }}"
                                                    alt="{{ $item['product_name'] ?? '' }}">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                            @endif
                                        </div>

                                        <div>
                                            <div class="review-product-category">Cordão</div>
                                            <div class="review-product-name">{{ $item['product_name'] ?? '-' }}</div>
                                            <div class="review-product-qty">Qtd : {{ $quantity }}</div>
                                        </div>

                                        <div class="review-price-box">
                                            <div>Preço Unitário</div>
                                            <strong>¥ {{ number_format($unitPrice, 2) }} /un</strong>

                                            <div>Total do Item</div>
                                            <strong>¥ {{ number_format($itemTotal, 2) }}</strong>

                                            <button type="button" class="review-detail-link js-review-detail-toggle"
                                                data-target-id="review-detail-{{ $loop->index }}">
                                                <img class="review-detail-arrow"
                                                    src="{{ asset('assets/images/icon/weui_arrow-filled.png') }}" alt="">
                                                <span class="review-detail-text">Detalhes</span>
                                            </button>
                                        </div>
                                    </div>
                                    @php
                                        $options = $item['options'] ?? [];
                                        $customColors = $item['custom_colors'] ?? [];
                                        $groupedOptions = collect($options)->groupBy('group_name');
                                    @endphp

                                    <div class="review-detail-box" id="review-detail-{{ $loop->index }}">
                                        @if (!empty($options))
                                            @foreach ($groupedOptions as $groupName => $groupItems)
                                                <div class="review-detail-row">
                                                    <div class="review-detail-label">
                                                        {{ $groupName }}
                                                    </div>

                                                    <div class="review-detail-value">
                                                        @if (str_contains(strtolower($groupName), 'cor') || str_contains(strtolower($groupName), 'color'))
                                                            <div class="review-color-list">
                                                                @foreach ($groupItems as $opt)
                                                                    <div class="review-color-item">
                                                                        @if (!empty($opt['color_code']) || !empty($opt['variant_color_code']))
                                                                            <span class="review-color-dot"
                                                                                style="background: {{ $opt['color_code'] ?? $opt['variant_color_code'] }};"></span>
                                                                        @endif

                                                                        <span>
                                                                            {{ $opt['option_name'] ?? '-' }}

                                                                            @if (!empty($opt['variant_name']))
                                                                                - {{ $opt['variant_name'] }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            @foreach ($groupItems as $opt)
                                                                <div class="review-detail-text">
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
                                        @endif

                                        @if (!empty($customColors))
                                            <div class="review-detail-row">
                                                <div class="review-detail-label">
                                                    Special Cord Colors
                                                </div>

                                                <div class="review-detail-value">
                                                    <div class="review-color-list">
                                                        @foreach ($customColors as $color)
                                                            <div class="review-color-item">
                                                                <span>{{ $color['value'] ?? '-' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DETALHES DE ENVIO --}}
                        <div class="review-card">
                            <div class="review-card-header">
                                <div class="review-card-title">Detalhes de Envio</div>
                                <a href="{{ route('checkout.address') }}" class="review-edit-link">Editar</a>
                            </div>

                            <div class="review-body">
                                <div class="info-grid">
                                    <div class="info-label">Entregar para</div>
                                    <div class="info-value">
                                        {{ $personal['first_name'] ?? '' }} {{ $personal['last_name'] ?? '' }}<br>
                                        {{ $shippingAddress['city'] ?? '' }} {{ $shippingAddress['area'] ?? '' }}<br>
                                        {{ $shippingAddress['province'] ?? '' }}, {{ $shippingAddress['postcode'] ?? '' }}
                                    </div>

                                    <div class="info-label">Informações de Contato</div>
                                    <div class="info-value">
                                        {{ $personal['email'] ?? '-' }}<br>
                                        {{ $personal['phone'] ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DETALHES DE PAGAMENTO --}}
                        <div class="review-card">
                            <div class="review-card-header">
                                <div class="review-card-title">Detalhes de Pagamento</div>
                                <a href="{{ route('checkout.payment') }}" class="review-edit-link">Editar</a>
                            </div>

                            <div class="review-body">
                                <div class="info-grid">
                                    <div class="info-label">Pago com</div>
                                    <div class="info-value">
                                        @if ($paymentMethod === 'bank_transfer')
                                            <div class="payment-method-title">
                                                <span>🏦</span>
                                                <span>Transferência Bancária (JP banks).</span>
                                            </div>

                                            <div class="payment-bank-detail">
                                                <p>
                                                    Aceitamos pagamentos via transferência para o BANCO YUZU (ゆうず銀行):
                                                    Agência 001, Conta Poupança (普通), Titular XXXX TOYS LTD.
                                                </p>

                                                <p>
                                                    Após concluir, envie o comprovante para xxxxx@geektoys.jp ou pelo
                                                    WhatsApp:
                                                    +81 XX XXXX-XXXX.
                                                </p>

                                                <p class="payment-warning">
                                                    ⚠️ <strong>Atenção:</strong> O pagamento deve ser realizado em até 1
                                                    hora após a confirmação do pedido.
                                                    Caso contrário, o pedido será cancelado automaticamente e você receberá
                                                    uma notificação por e-mail.
                                                </p>
                                            </div>
                                        @elseif($paymentMethod === 'paypal')
                                            <div class="payment-method-title">
                                                <span style="font-weight:800; color:#1f5fae;">PayPal</span>
                                            </div>

                                            <div class="payment-bank-detail">
                                                Rápido e Seguro. Pague com sua conta PayPal.
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </div>

                                    <div class="info-label">Endereço de Faturamento</div>
                                    <div class="info-value">
                                        {{ $billing['first_name'] ?? '' }} {{ $billing['last_name'] ?? '' }}<br>
                                        {{ $billing['city'] ?? '' }} {{ $billing['area'] ?? '' }}<br>
                                        {{ $billing['province'] ?? '' }}, {{ $billing['postcode'] ?? '' }}
                                    </div>

                                    <div class="info-label">Informações de Contato</div>
                                    <div class="info-value">
                                        {{ $billing['email'] ?? '-' }}<br>
                                        {{ $billing['phone'] ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if(session('error'))
    <div style="background:#fee2e2; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:16px;">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div style="background:#dcfce7; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:16px;">
        {{ session('success') }}
    </div>
@endif

                  @include('checkout.partials.summary-sidebar', [
    'backRoute' => route('checkout.payment'),
    'backText' => 'Voltar ao Pagamento',
    'nextText' => 'FINALIZAR PEDIDO →',
])
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.js-review-detail-toggle').forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetId = this.dataset.targetId;
                    const target = document.getElementById(targetId);

                    if (!target) {
                        return;
                    }

                    target.classList.toggle('is-open');
                    this.classList.toggle('is-open');
                });
            });
        });
    </script>
@endsection
