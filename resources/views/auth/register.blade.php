@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
<div class="register-page">
    <div class="register-left">
        <img src="{{ asset('assets/images/login/image 131.png') }}" alt="Register" class="register-image">
    </div>

    <div class="register-right">
        <div class="register-card">
            <h1 class="register-title">Sign Up</h1>

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
                        <label class="register-label">First Name <span>*</span></label>
                        <input
                            type="text"
                            name="first_name"
                            class="register-input"
                            placeholder="First Name"
                            value="{{ old('first_name') }}"
                            required
                        >
                    </div>

                    <div class="register-group">
                        <label class="register-label">Last Name <span>*</span></label>
                        <input
                            type="text"
                            name="last_name"
                            class="register-input"
                            placeholder="Last Name"
                            value="{{ old('last_name') }}"
                            required
                        >
                    </div>
                </div>

                <div class="register-group">
                    <label class="register-label">Email <span>*</span></label>
                    <input
                        type="email"
                        name="email"
                        class="register-input"
                        placeholder="Email address"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="register-group">
                    <label class="register-label">Password <span>*</span></label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="register-input"
                        placeholder="Password"
                        required
                    >
                </div>

                <div class="password-rules">
                    <div class="password-rule" id="rule-length">
                        <span class="rule-icon">×</span>
                        <span>8 characters minimum</span>
                    </div>

                    <div class="password-rule" id="rule-number">
                        <span class="rule-icon">×</span>
                        <span>1 number</span>
                    </div>

                    <div class="password-rule" id="rule-uppercase">
                        <span class="rule-icon">×</span>
                        <span>1 uppercase letter</span>
                    </div>
                </div>

                <div class="register-group">
                    <label class="register-label">Confirm Password <span>*</span></label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="register-input"
                        placeholder="Confirm Password"
                        required
                    >
                </div>

              <label class="register-checkbox">
    <input type="checkbox" name="term_policy" value="1" required>
    <span>
        By creating an account with xxxxx, I verify that I have read and agree to the
        Terms and Conditions as well as our Privacy Policy.
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
        I would like to receive emails and notifications from xxxxx about news,
        discounts, and sales.
    </span>
</label>

                <button type="submit" class="register-submit-btn">
                    Create Account
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