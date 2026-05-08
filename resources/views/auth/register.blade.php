@extends('layouts.app')

@section('title', __('messages.auth.sign_up_title'))

@section('content')
<div class="register-page">
    <div class="register-left">
        <img src="{{ asset('assets/images/login/image 131.png') }}" alt="Register" class="register-image">
    </div>

    <div class="register-right">
        <div class="register-card">
            <h1 class="register-title">{{ __('messages.auth.sign_up_title') }}</h1>

            @if (session('message'))
                <div class="auth-alert auth-alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-alert auth-alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="register-row">
                    <div class="register-group">
                        <label class="register-label">{{ __('messages.auth.first_name') }} <span>*</span></label>
                        <input
                            type="text"
                            name="first_name"
                            class="register-input"
                            placeholder="{{ __('messages.auth.first_name') }}"
                            value="{{ old('first_name') }}"
                            required
                        >
                    </div>

                    <div class="register-group">
                        <label class="register-label">{{ __('messages.auth.last_name') }} <span>*</span></label>
                        <input
                            type="text"
                            name="last_name"
                            class="register-input"
                            placeholder="{{ __('messages.auth.last_name') }}"
                            value="{{ old('last_name') }}"
                            required
                        >
                    </div>
                </div>

                <div class="register-group">
                    <label class="register-label">{{ __('messages.auth.email') }} <span>*</span></label>
                    <input
                        type="email"
                        name="email"
                        class="register-input"
                        placeholder="{{ __('messages.auth.email_placeholder') }}"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="register-group">
                    <label class="register-label">{{ __('messages.auth.password') }} <span>*</span></label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="register-input"
                        placeholder="{{ __('messages.auth.password_placeholder') }}"
                        required
                    >
                </div>

                <div class="password-rules">
                    <div class="password-rule" id="rule-length">
                        <span class="rule-icon">×</span>
                        <span>{{ __('messages.auth.password_rules.length') }}</span>
                    </div>

                    <div class="password-rule" id="rule-number">
                        <span class="rule-icon">×</span>
                        <span>{{ __('messages.auth.password_rules.number') }}</span>
                    </div>

                    <div class="password-rule" id="rule-uppercase">
                        <span class="rule-icon">×</span>
                        <span>{{ __('messages.auth.password_rules.uppercase') }}</span>
                    </div>
                </div>

                <div class="register-group">
                    <label class="register-label">{{ __('messages.auth.confirm_password') }} <span>*</span></label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="register-input"
                        placeholder="{{ __('messages.auth.confirm_password') }}"
                        required
                    >
                </div>

              <label class="register-checkbox">
    <input type="checkbox" name="term_policy" value="1" required>
    <span>
        {{ __('messages.auth.agree_terms') }}
    </span>
</label>

<label class="register-checkbox">
    <input
        type="checkbox"
        name="receive_email"
        value="1"
        {{ old('receive_email', '1') ? 'checked' : '' }}
    >
    <span>
        {{ __('messages.auth.receive_news') }}
    </span>
</label>

                <button type="submit" class="register-submit-btn">
                    {{ __('messages.auth.create_account') }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');

    const rules = {
        length: document.getElementById('rule-length'),
        number: document.getElementById('rule-number'),
        uppercase: document.getElementById('rule-uppercase'),
    };

    function updateRule(element, passed) {
        const icon = element.querySelector('.rule-icon');

        if (passed) {
            element.classList.add('passed');
            icon.textContent = '✓';
        } else {
            element.classList.remove('passed');
            icon.textContent = '×';
        }
    }

    passwordInput.addEventListener('input', function () {
        const value = passwordInput.value;

        updateRule(rules.length, value.length >= 8);
        updateRule(rules.number, /[0-9]/.test(value));
        updateRule(rules.uppercase, /[A-Z]/.test(value));
    });
});
</script>
@endsection