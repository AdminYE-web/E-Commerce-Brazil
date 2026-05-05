@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Password Reset</h1>

        <p class="auth-desc">
            Enter your account email address to receive a verification code to reset your password.
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

            <button type="submit" class="auth-submit-btn">
                Send Verification Code
            </button>
        </form>

        <p class="auth-register-text">
            <a href="{{ route('login') }}" class="auth-link">Back to login</a>
        </p>
    </div>
</div>
@endsection