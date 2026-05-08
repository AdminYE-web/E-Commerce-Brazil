@extends('layouts.app')

@section('title', __('messages.auth.forgot_password'))

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">{{ __('messages.auth.reset_password_title') }}</h1>

        <p class="auth-desc">
            {{ __('messages.auth.reset_password_desc') }}
        </p>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="auth-group">
                <label for="email" class="auth-label">{{ __('messages.auth.email') }}</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="auth-input"
                    placeholder="{{ __('messages.auth.email_placeholder') }}"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <button type="submit" class="auth-submit-btn">
                {{ __('messages.auth.send_verification') }}
            </button>
        </form>

        <p class="auth-register-text">
            <a href="{{ route('login') }}" class="auth-link">{{ __('messages.auth.back_to_login') }}</a>
        </p>
    </div>
</div>
@endsection