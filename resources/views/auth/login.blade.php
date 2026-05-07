@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Sign in to your account</h1>

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
                <label for="email" class="auth-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="auth-input"
                    placeholder="Email address"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="auth-group">
                <label for="password" class="auth-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="auth-input"
                    placeholder="Password"
                    required
                >
            </div>

            <div class="auth-forgot-wrap">
               <a href="{{ route('password.request') }}" class="auth-link">Forgot password ?</a>
            </div>

            <button type="submit" class="auth-submit-btn">Sign In</button>
        </form>

        <div class="auth-divider">
            <span>or</span>
        </div>

        <div class="auth-social-wrap">
            <a href="{{ url('/auth/google/redirect') }}" class="auth-social-btn">
                <img class="text-start" src="{{ asset('assets/images/login/google-icon.png') }}" alt="">
                <span>Continue with Google</span>
            </a>

            {{-- <a href="{{ url('/auth/facebook/redirect') }}" class="auth-social-btn">
                <img class="text-start" src="{{ asset('assets/images/login/face-icon.png') }}" alt="">
                <span>Continue with Facebook</span>
            </a> --}}
        </div>

        <p class="auth-register-text">
            Don’t have an account yet?
            <a href="{{ route('register') }}" class="auth-link">Register here</a>
        </p>
    </div>
</div>
@endsection