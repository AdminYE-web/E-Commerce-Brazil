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
    border: 1px solid #d1d5db;
    border-radius: 8px;
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
    width: 18px;
    height: 18px;
    accent-color: #2563eb;
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

                    @if($errors->any())
                        <div class="error-box">
                            Please select payment method.
                        </div>
                    @endif

                    <label class="payment-card {{ $selectedPayment === 'paypal' ? 'is-selected' : '' }}">
                        <div class="payment-card-header">
                            <div class="payment-logo paypal-text">
                                PayPal
                            </div>

                            <div>
                                <div class="payment-title">Paypal.</div>
                                <div class="payment-desc">Rápido e Seguro. Pague com sua conta PayPal.</div>
                            </div>

                            <input
                                type="radio"
                                name="payment_method"
                                value="paypal"
                                class="payment-check"
                                {{ $selectedPayment === 'paypal' ? 'checked' : '' }}
                            >
                        </div>
                    </label>

                    <label class="payment-card {{ $selectedPayment === 'bank_transfer' ? 'is-selected' : '' }}">
                        <div class="payment-card-header">
                            <div class="bank-header-left">
                                <span class="bank-icon">🏦</span>
                                <span>Transferência Bancária (JP banks).</span>
                            </div>

                            <div></div>

                            <input
                                type="radio"
                                name="payment_method"
                                value="bank_transfer"
                                class="payment-check"
                                {{ $selectedPayment === 'bank_transfer' ? 'checked' : '' }}
                            >
                        </div>

                        <div class="payment-bank-body">
                            <p>
                                Aceitamos pagamentos via transferência para o BANCO YUZU (ゆうず銀行):
                                Agência 001, Conta Poupança (普通), Titular XXXX TOYS LTD.
                            </p>

                            <p>
                                Após concluir, envie o comprovante para xxxxx@geektoys.jp ou pelo WhatsApp:
                                +81 XX XXXX-XXXX (clique aqui).
                            </p>

                            <p class="payment-warning">
                                ⚠️ <strong>Atenção:</strong> O pagamento deve ser realizado em até 1 hora após a confirmação do pedido.
                                Caso contrário, o pedido será cancelado automaticamente e você receberá uma notificação por e-mail.
                            </p>
                        </div>
                    </label>

                </div>

                @include('checkout.partials.summary-sidebar', [
                    'backRoute' => route('checkout.address'),
                    'backText' => 'Voltar ao Endereço',
                    'nextText' => 'Próximo Passo: Revisão →',
                ])
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
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