@extends('layouts.app')

@section('title', 'Verification Success')

@section('content')
<div class="verify-success-page">
    <div class="verify-success-card">
        <div class="verify-success-icon-wrap">
            <div class="verify-success-icon">
                <span>✓</span>
            </div>
            <div class="verify-success-badge">✓</div>
        </div>

        <h1 class="verify-success-title">Successful!</h1>

        <p class="verify-success-text">
            Your account is created successfully <br>
            and ready now.
        </p>

        <a href="{{ route('login') }}" class="verify-success-btn">
            Get Started
        </a>
    </div>
</div>
@endsection