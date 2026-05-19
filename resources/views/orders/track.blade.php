@extends('layouts.app')

@section('title', 'Track Order')

@section('css')
<style>
    .track-page {
        min-height: 520px;
        padding: 38px 16px 80px;
        background: #fff;
    }

    .track-form-card {
        width: 100%;
        max-width: 390px;
        margin: 0 auto;
    }

    .track-title {
        margin: 0 0 24px;
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        color: #111;
    }

    .track-desc {
        margin: 0 0 24px;
        font-size: 14px;
        line-height: 1.5;
        color: #222;
    }

    .track-form-group {
        margin-bottom: 20px;
    }

    .track-form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        color: #111;
    }

    .track-form-group label span {
        color: #e11d48;
    }

    .track-input {
        width: 100%;
        height: 38px;
        border: 1px solid #d1d5db;
        border-radius: 5px;
        padding: 0 12px;
        font-size: 14px;
        outline: none;
    }

    .track-input:focus {
        border-color: #2f6fc7;
    }

    .track-btn {
        width: 100%;
        height: 38px;
        border: 0;
        border-radius: 999px;
        background: #2f6fc7;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .track-error {
        margin-bottom: 16px;
        padding: 10px 12px;
        border-radius: 6px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 13px;
    }
</style>
@endsection

@section('content')
<section class="track-page">
    <div class="track-form-card">
        <h1 class="track-title">Track your order</h1>

        <p class="track-desc">
            Track your order Enter your email address and Order number to track your order summary.
        </p>

        @if($errors->any())
            <div class="track-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('track-order.search') }}" method="POST">
            @csrf

            <div class="track-form-group">
                <label>Order Number <span>*</span></label>
                <input
                    type="text"
                    name="order_no"
                    value="{{ old('order_no') }}"
                    class="track-input"
                    placeholder="Order Number"
                    required
                >
            </div>

            <div class="track-form-group">
                <label>Email <span>*</span></label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="track-input"
                    placeholder="Email address"
                    required
                >
            </div>

            <button type="submit" class="track-btn">
                ⌕ Track Order
            </button>
        </form>
    </div>
</section>
@endsection