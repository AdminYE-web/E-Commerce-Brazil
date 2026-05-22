@extends('layouts.app')

@section('title', 'Pedido Confirmado')

@section('css')
    <style>
        .order-success-page {
            min-height: calc(100vh - 120px);
            background: #fff;
            padding: 70px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .order-success-wrap {
            width: 100%;
            max-width: 980px;
            text-align: center;
            margin: 0 auto;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .success-title {
            font-size: 42px;
            font-weight: 900;
            color: #000;
            margin-bottom: 22px;
        }

        .success-desc {
            max-width: 780px;
            margin: 0 auto 42px;
            font-size: 22px;
            line-height: 1.45;
            color: #667895;
            font-weight: 400;
        }

        .order-info-box {
            max-width: 930px;
            margin: 0 auto 48px;
            background: #f6f8fb;
            border-radius: 22px;
            padding: 24px 48px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            text-align: left;
        }

        .order-info-label {
            font-size: 14px;
            color: #8aa2ce;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .order-info-value {
            font-size: 16px;
            color: #000;
            font-weight: 800;
        }

        .payment-status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 250px;
            height: 38px;
            padding: 0 24px;
            border-radius: 999px;
            background: #ffefb8;
            color: #9a4b00;
            font-size: 16px;
            font-weight: 800;
        }

        .success-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
            margin-bottom: 58px;
        }

        .success-btn {
            min-width: 252px;
            height: 56px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 20px;
            font-weight: 800;
        }

        .success-btn-primary {
            background: #1f5a91;
            color: #fff;
            border: 1px solid #1f5a91;
        }

        .success-btn-primary:hover {
            color: #fff;
            background: #174a79;
        }

        .success-btn-outline {
            background: #fff;
            color: #475569;
            border: 1px solid #dbe3ee;
        }

        .success-btn-outline:hover {
            color: #1f2937;
            background: #f8fafc;
        }

        .success-help {
            font-size: 16px;
            color: #34c759;
        }

        .success-help strong {
            font-weight: 900;
        }

        @media (max-width: 768px) {
            .order-success-page {
                padding: 45px 16px;
            }

            .success-title {
                font-size: 32px;
            }

            .success-desc {
                font-size: 18px;
            }

            .order-info-box {
                grid-template-columns: 1fr;
                padding: 24px;
                text-align: center;
            }

            .success-actions {
                flex-direction: column;
                gap: 16px;
            }

            .success-btn {
                width: 100%;
                max-width: 320px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $payment = $order->payment ?? null;
        $customer = $order->customer ?? null;

        $paymentStatus = $payment->payment_status ?? 'pending';

        $paymentStatusText = match ($paymentStatus) {
            'paid' => 'Pago',
            'failed' => 'Falhou',
            'cancelled' => 'Cancelado',
            'refunded' => 'Reembolsado',
            default => 'Aguardando Confirmação',
        };

        $confirmationEmail = $customer->personal_email ?? ($customer->billing_email ?? '-');
    @endphp

    <div class="order-success-page">
        <div class="order-success-wrap">

            <div class="success-icon">
                {{-- ถ้ามีรูป icon ตามตัวอย่าง ให้เปลี่ยน path ตรงนี้ --}}
                <img src="{{ asset('assets/images/icon/success-check.png') }}" alt="Success">
            </div>

            <h1 class="success-title">
                {{ __('checkout.success.title') }}
            </h1>

            <p class="success-desc">
                {{ __('checkout.success.subtitle') }}
            </p>

            <div class="order-info-box">
                <div class="order-info-item">
                    <div class="order-info-label">{{ __('checkout.success.order_number') }}</div>
                    <div class="order-info-value">#{{ $order->order_no }}</div>
                </div>

                <div class="order-info-item">
                    <div class="order-info-label">{{ __('checkout.success.payment_status') }}</div>
                    <div class="order-info-value">
                        <span class="payment-status-pill">
                            {{ $paymentStatusText }}
                        </span>
                    </div>
                </div>

                <div class="order-info-item">
                    <div class="order-info-label">{{ __('checkout.success.confirmation_email') }}</div>
                    <div class="order-info-value">
                        {{ $confirmationEmail }}
                    </div>
                </div>
            </div>

            <div class="success-actions">
                <a href="#" class="success-btn success-btn-primary">
                    Acompanhar Pedido
                </a>

                <a href="{{ route('products.index') }}" class="success-btn success-btn-outline">
                    Continuar Comprando
                </a>
            </div>

            <div class="success-help">
                Alguma dúvida? Fale conosco via WhatsApp
                <strong>+81 090-1234-4567</strong>
            </div>

        </div>
    </div>
@endsection
