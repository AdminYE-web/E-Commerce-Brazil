@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Create new password</h1>
        <p class="auth-desc">We'll ask for this password whenever you Sign-In.</p>

        @if ($errors->any())
            <div class="auth-alert auth-alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="auth-group">
                <label for="email" class="auth-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="auth-input"
                    placeholder="Email address"
                    value="{{ old('email', $email) }}"
                    required
                >
            </div>

            <div class="auth-group">
                <label for="password" class="auth-label">New Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="auth-input"
                    placeholder="New password"
                    required
                >
            </div>

            <div class="auth-group">
                <label for="password_confirmation" class="auth-label">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="auth-input"
                    placeholder="Confirm password"
                    required
                >
            </div>

            <button type="submit" class="auth-submit-btn">
                Save changes and Sign-In
            </button>
        </form>
    </div>
</div>
@endsection