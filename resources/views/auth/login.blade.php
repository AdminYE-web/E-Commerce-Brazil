@extends('layouts.app')

@section('title', __('messages.footer.login'))

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">{{ __('messages.auth.login_title') }}</h1>

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

        <form method="POST" action="{{ route('login.submit') }}">
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

            <div class="auth-group">
                <label for="password" class="auth-label">{{ __('messages.auth.password') }}</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="auth-input"
                    placeholder="{{ __('messages.auth.password_placeholder') }}"
                    required
                >
            </div>

            <div class="auth-forgot-wrap">
               <a href="{{ route('password.request') }}" class="auth-link">{{ __('messages.auth.forgot_password') }}</a>
            </div>

            <button type="submit" class="auth-submit-btn">{{ __('messages.auth.sign_in') }}</button>
        </form>

        <div class="auth-divider">
            <span>{{ __('messages.auth.or') }}</span>
        </div>

        <div class="auth-social-wrap">
            <a href="{{ route('auth.google.redirect') }}" class="auth-social-btn">
                <img class="text-start" src="{{ asset('assets/images/login/google-icon.png') }}" alt="">
                <span>{{ __('messages.auth.continue_with_google') }}</span>
            </a>

            {{-- <a href="{{ url('/auth/facebook/redirect') }}" class="auth-social-btn">
                <img class="text-start" src="{{ asset('assets/images/login/face-icon.png') }}" alt="">
                <span>Continue with Facebook</span>
            </a> --}}
        </div>

        <p class="auth-register-text">
            {{ __('messages.auth.dont_have_account') }}
            <a href="{{ route('register') }}" class="auth-link">{{ __('messages.auth.register_here') }}</a>
        </p>
    </div>
</div>
@endsection