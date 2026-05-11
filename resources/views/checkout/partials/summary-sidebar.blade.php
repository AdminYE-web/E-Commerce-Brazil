<style>
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

.summary-line span {
    font-weight: 400;
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

.summary-action-divider {
    margin: 12px 0 18px;
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

.checkout-back-btn:hover {
    color: #111;
    background: #f8fafc;
}

.checkout-next-btn {
    border: 0;
    background: #2f6fc2;
    color: #fff;
}

.checkout-next-btn:hover {
    background: #255fac;
    color: #fff;
}
</style>
<aside class="checkout-summary">
    <h3>Finalizar Compra</h3>

    <div class="summary-title">
        Order Summary
    </div>

    <div class="summary-divider"></div>

    <div class="summary-line">
        <span>Items :</span>
        <strong>{{ $totalItems }} products</strong>
    </div>

    <div class="summary-line">
        <span>Quantidade Total :</span>
        <strong>{{ $totalQty }} pcs</strong>
    </div>

    <div class="summary-divider"></div>

    <div class="summary-line">
        <span>Subtotal :</span>
        <strong>¥ {{ number_format($subtotal, 2) }}</strong>
    </div>

    <div class="summary-line">
        <span>Frete :</span>
        <strong>¥ {{ number_format($shipping, 2) }}</strong>
    </div>

    <div class="summary-line">
        <span>Imposto Estimado :</span>
        <strong>¥ {{ number_format($tax, 2) }}</strong>
    </div>

    <div class="summary-divider"></div>

    <div class="summary-total">
        <span>Total</span>
        <strong>¥ {{ number_format($grandTotal, 2) }}</strong>
    </div>

    <div class="checkout-tip">
        💡 Dica: Frete ¥800. Grátis em pedidos acima de ¥10,000 (valor bruto).
    </div>

    <div class="coupon-row">
        <input type="text" placeholder="Cartão Presente ou Cupom">
        <button type="button">›</button>
    </div>

    <div class="summary-divider summary-action-divider"></div>

    @if(!empty($backRoute))
        <a href="{{ $backRoute }}" class="checkout-back-btn">
            {{ $backText ?? 'Voltar' }}
        </a>
    @endif

@if(!empty($nextText))
    <button type="submit" class="checkout-next-btn">
        {{ $nextText }}
    </button>
@endif
</aside>