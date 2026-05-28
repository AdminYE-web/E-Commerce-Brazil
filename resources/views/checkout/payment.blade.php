@extends('layouts.app')

@section('title', 'Checkout Payment')

@section('css')
    <style>
        .checkout-page {
            background: #f5f6f8;
            padding: 30px 0 60px;
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
            width: calc(((100% - 140px) / 4) * 3);
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

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 28px;
            align-items: start;
        }

        .payment-card {
            display: block;
            width: 100%;
            box-sizing: border-box;

            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }

        .payment-card.is-selected {
            border-color: #2f6fc2;
            background: #eef6ff;
            box-shadow: 0 0 0 1px #2f6fc2;
        }

        .payment-card-header {
            width: 100%;
            min-height: 116px;
            display: grid;
            grid-template-columns: 50% 1fr auto;
            gap: 18px;
            align-items: center;
            padding: 24px 28px;
            box-sizing: border-box;
        }

        .payment-logo {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .payment-logo.paypal-text {
            font-size: 44px;
            font-weight: 800;
            color: #1f5fae;
            letter-spacing: -1px;
        }

        .payment-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .payment-desc {
            font-size: 13px;
            color: #111;
        }

        .payment-check {
            -webkit-appearance: none !important;
            appearance: none !important;
            background-color: #fff !important;
            margin: 0 !important;
            width: 22px !important;
            height: 22px !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 6px !important;
            display: inline-grid !important;
            place-content: center !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            position: relative !important;
        }

        .payment-check:hover:not(:disabled) {
            border-color: #9ca3af !important;
        }

        .payment-check:checked {
            border-color: #2f6fc2 !important;
            background-color: #2f6fc2 !important;
        }

        /* Beautiful Image Checkmark */
        .payment-check::before {
            content: "" !important;
            width: 14px !important;
            height: 14px !important;
            background-image: url('/assets/images/icon/ion_checkmark-sharp.png') !important;
            background-size: contain !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            transform: scale(0) !important;
            transition: 120ms transform ease-in-out !important;
        }

        .payment-check:checked::before {
            transform: scale(1) !important;
        }

        .bank-icon {
            font-size: 26px;
            margin-right: 12px;
        }

        .bank-header-left {
            display: flex;
            align-items: center;
            font-size: 18px;
            font-weight: 800;
        }

        .payment-bank-body {
            border-top: 1px solid #d1d5db;
            padding: 18px 28px 22px;
            font-size: 13px;
            line-height: 1.7;
            background: #fff;
        }

        .payment-warning {
            margin-top: 12px;
            font-size: 13px;
        }

        .payment-warning strong {
            font-weight: 800;
        }

        .error-box {
            color: #ef4444;
            background: #fff;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 16px;
        }

        /* summary common */
        .checkout-summary {
            background: #fff;
            border-radius: 0;
            padding: 28px 30px;
            position: sticky;
            top: 20px;
            width: 100%;
        }

        .checkout-summary h3 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 14px;
            color: #111;
        }

        .summary-title {
            font-size: 16px;
            font-weight: 800;
            color: #111;
            margin-bottom: 12px;
        }

        .summary-divider {
            width: 100%;
            height: 1px;
            background: #dcdcdc;
            margin: 10px 0;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 6px 0;
            border-bottom: 0;
            font-size: 15px;
            color: #111;
        }

        .summary-line strong {
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 4px 0 10px;
            border-bottom: 0;
            font-size: 22px;
            font-weight: 800;
            color: #111;
        }

        .summary-total span,
        .summary-total strong {
            font-size: 22px;
            font-weight: 800;
        }

        .checkout-tip {
            background: #eef5ff;
            color: #2457a6;
            padding: 12px 14px;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.6;
            margin: 14px 0 20px;
        }

        .coupon-row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
        }

        .coupon-row input {
            flex: 1;
            height: 38px;
            border: 1px solid #cfd4dc;
            border-radius: 5px;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
        }

        .coupon-row button {
            width: 38px;
            height: 38px;
            border: 0;
            margin-left: 5px;
            background: #1d4f91;
            color: #fff;
            border-radius: 5px;
            font-size: 24px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkout-back-btn,
        .checkout-next-btn {
            width: 100%;
            height: 36px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            font-weight: 800;
        }

        .checkout-back-btn {
            border: 1px solid #d1d5db;
            color: #111;
            background: #fff;
            margin-bottom: 14px;
        }

        .checkout-next-btn {
            border: 0;
            background: #2f6fc2;
            color: #fff;
        }

        @media (max-width: 991px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .checkout-summary {
                position: static;
            }

            .payment-card-header {
                grid-template-columns: 1fr auto;
            }

            .payment-logo {
                grid-column: 1 / -1;
            }
        }

        .payment-card.is-disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Bank Transfer Card Custom Premium Styles */
        .bank-transfer-card {
            border-radius: 12px !important;
            border: 1px solid #cbd5e1 !important;
            background: #fff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease-in-out !important;
        }

        .bank-transfer-card.is-selected {
            border-color: #cbd5e1 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .bank-transfer-card .payment-card-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 16px 20px !important;
            min-height: auto !important;
            border-bottom: 1px solid #eeeeee !important;
            background: #fff !important;
        }

        /* Bank Transfer Card Custom Premium Styles */
        .bank-transfer-card {
            border-radius: 12px !important;
            border: 1px solid #cbd5e1 !important;
            background: #fff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease-in-out !important;
        }

        .bank-transfer-card.is-selected {
            border-color: #2f6fc2 !important;
            background: #eef6ff !important;
            box-shadow: 0 0 0 1px #2f6fc2, 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .bank-transfer-card .payment-card-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 16px 20px !important;
            min-height: auto !important;
            border-bottom: 1px solid #eeeeee !important;
            background: transparent !important;
        }

        .bank-transfer-card .bank-header-left {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #000000 !important;
        }

        .bank-transfer-card .bank-icon {
            font-size: 22px !important;
            margin-right: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .bank-transfer-card .bank-title-text {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #000000 !important;
        }

        .bank-transfer-card .payment-bank-body {
            border-top: none !important;
            padding: 20px !important;
            background: transparent !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
            color: #111111 !important;
        }

        .bank-transfer-card .payment-bank-body p {
            margin: 0 0 16px 0 !important;
        }

        .bank-transfer-card .payment-bank-body p:last-child {
            margin-bottom: 0 !important;
        }

        /* Warning alignment and style */
        .bank-transfer-card .payment-warning {
            display: flex !important;
            align-items: flex-start !important;
            gap: 8px !important;
            margin-top: 16px !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
            color: #111111 !important;
        }

        .bank-transfer-card .payment-warning .warning-icon {
            font-size: 16px !important;
            flex-shrink: 0 !important;
            margin-top: 2px !important;
        }

        /* PayPal Card Custom Premium Styles */
        .paypal-card {
            border-radius: 12px !important;
            border: 1px solid #cbd5e1 !important;
            background: #fff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease-in-out !important;
        }

        .paypal-card.is-selected {
            border-color: #2f6fc2 !important;
            background: #eef6ff !important;
            box-shadow: 0 0 0 1px #2f6fc2, 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .paypal-card .payment-card-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 20px 20px 10px 20px !important;
            min-height: auto !important;
            background: transparent !important;
        }

        .paypal-card .payment-logo.paypal-text {
            font-size: 26px !important;
            font-weight: 800 !important;
            color: #1f5fae !important;
            letter-spacing: -1px !important;
        }

        .paypal-card .payment-paypal-body {
            padding: 0 20px 20px 20px !important;
            background: transparent !important;
        }

        .paypal-card .payment-title {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #000000 !important;
            margin-bottom: 6px !important;
        }

        .paypal-card .payment-desc {
            font-size: 14px !important;
            line-height: 1.5 !important;
            color: #555555 !important;
        }

        .paypal-card.is-disabled {
            opacity: 0.6 !important;
        }
    </style>
@endsection

@section('content')
    @php
        $selectedPayment = session('checkout_payment.payment_method', 'paypal');
    @endphp

    <form action="{{ route('checkout.storePaymentStep') }}" method="POST">
        @csrf

        <div class="checkout-page">
            <div class="container">

                @include('checkout.partials.stepper', ['currentStep' => 4])

                <div class="checkout-layout">
                    <div class="checkout-left">

                        @if ($errors->any())
                            <div class="error-box">
                                Please select payment method.
                            </div>
                        @endif

                        {{-- <label class="payment-card paypal-card {{ $selectedPayment === 'paypal' ? 'is-selected' : '' }}">
                            <div class="payment-card-header">
                                <div class="payment-logo paypal-text">
                                    PayPal
                                </div>

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="paypal"
                                    class="payment-check"
                                    {{ $selectedPayment === 'paypal' ? 'checked' : '' }}
                                >
                            </div>

                            <div class="payment-paypal-body">
                                <div class="payment-title">Paypal.</div>
                                <div class="payment-desc">Rápido e Seguro. Pague com sua conta PayPal.</div>
                            </div>
                        </label> --}}

                        <label class="payment-card paypal-card is-disabled">
                            <div class="payment-card-header">
                                <div class="payment-logo paypal-text">
                                    PayPal
                                </div>

                                <input type="radio" name="payment_method" value="paypal" class="payment-check" disabled>
                            </div>

                            <div class="payment-paypal-body">
                                <div class="payment-title">PayPal</div>
                                <div class="payment-desc">
                                    {{ __('checkout.step_4.maintenance') }}
                                </div>
                            </div>
                        </label>

                        <label class="payment-card bank-transfer-card {{ $selectedPayment === 'bank_transfer' ? 'is-selected' : '' }}">
                            <div class="payment-card-header">
                                <div class="bank-header-left">
                                    <span class="bank-icon">🏛️</span>
                                    <span class="bank-title-text">{{ __('checkout.step_4.bank_transfer') }}</span>
                                </div>

                                <input type="radio" name="payment_method" value="bank_transfer" class="payment-check"
                                    {{ $selectedPayment === 'bank_transfer' ? 'checked' : '' }}>
                            </div>

                            <div class="payment-bank-body">
                                <p>
                                    {{ __('checkout.step_4.bank_transfer_body') }}
                                </p>

                                <p>
                                    {{ __('checkout.step_4.bank_transfer_notice') }}
                                </p>

                                @php
                                    $warningBody = __('checkout.step_4.bank_transfer_warning_body');
                                    $parts = preg_split('/(\.|。)/u', $warningBody, 2, PREG_SPLIT_DELIM_CAPTURE);
                                    $boldPart = ($parts[0] ?? '') . ($parts[1] ?? '');
                                    $restPart = $parts[2] ?? '';
                                @endphp

                                <p class="payment-warning">
                                    <span class="warning-icon">⚠️</span>
                                    <span>
                                        <strong>{{ __('checkout.step_4.bank_transfer_warning') }} {{ $boldPart }}</strong>{{ $restPart }}
                                    </span>
                                </p>
                            </div>
                        </label>

                    </div>

                    @include('checkout.partials.summary-sidebar', [
                        'backRoute' => route('checkout.address'),
                        'backText' => __('checkout.step_4.goback_shipping'),
                        'nextText' => __('checkout.step_4.next_review'),
                    ])
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCards = document.querySelectorAll('.payment-card');

            paymentCards.forEach(function(card) {
                const radio = card.querySelector('input[type="radio"]');

                card.addEventListener('click', function() {
                    if (!radio) {
                        return;
                    }

                    radio.checked = true;

                    paymentCards.forEach(function(item) {
                        item.classList.remove('is-selected');
                    });

                    card.classList.add('is-selected');
                });
            });
        });
    </script>
@endsection
