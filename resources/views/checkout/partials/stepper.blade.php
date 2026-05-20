@php
    $currentStep = $currentStep ?? 1;
@endphp

<div class="checkout-stepper">
    <div class="checkout-step {{ $currentStep > 1 ? 'completed' : 'current' }}">
        <div class="step-circle">
            {{ $currentStep > 1 ? '✓' : '1' }}
        </div>
        <div class="step-label">{{ __('checkout.step_view.cart') }}</div>
    </div>

    <div class="checkout-step {{ $currentStep > 2 ? 'completed' : ($currentStep == 2 ? 'current' : '') }}">
        <div class="step-circle">
            {{ $currentStep > 2 ? '✓' : '2' }}
        </div>
        <div class="step-label">{{ __('checkout.step_view.art_upload') }}</div>
    </div>

    <div class="checkout-step {{ $currentStep > 3 ? 'completed' : ($currentStep == 3 ? 'current' : '') }}">
        <div class="step-circle">
            {{ $currentStep > 3 ? '✓' : '3' }}
        </div>
        <div class="step-label">{{ __('checkout.step_view.shipping') }}</div>
    </div>

    <div class="checkout-step {{ $currentStep > 4 ? 'completed' : ($currentStep == 4 ? 'current' : '') }}">
        <div class="step-circle">
            {{ $currentStep > 4 ? '✓' : '4' }}
        </div>
        <div class="step-label">{{ __('checkout.step_view.payment') }}</div>
    </div>

    <div class="checkout-step {{ $currentStep == 5 ? 'current' : '' }}">
        <div class="step-circle">5</div>
        <div class="step-label">{{ __('checkout.step_view.review') }}</div>
    </div>
</div>