@extends('layouts.app')

@section('title', 'Checkout')

@section('css')
<style>
    .checkout-auth-page {
        background: #f5f6f8;
        min-height: 520px;
        padding: 70px 20px;
    }

    .checkout-auth-card {
        max-width: 720px;
        margin: 0 auto;
        background: #fff;
        border-radius: 18px;
        padding: 42px 36px;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }

    .checkout-auth-card h1 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 12px;
        color: #111;
    }

    .checkout-auth-card p {
        font-size: 16px;
        color: #667085;
        margin-bottom: 32px;
    }

    .checkout-auth-actions {
        display: flex;
        justify-content: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .checkout-auth-btn {
        min-width: 220px;
        height: 48px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 700;
        font-size: 15px;
    }

    .checkout-auth-btn.primary {
        background: #2f6fc2;
        color: #fff;
    }

    .checkout-auth-btn.primary:hover {
        background: #255fac;
        color: #fff;
    }

    .checkout-auth-btn.outline {
        background: #fff;
        color: #111;
        border: 1px solid #d1d5db;
    }

    .checkout-auth-btn.outline:hover {
        background: #f8fafc;
        color: #111;
    }

    .checkout-auth-note {
        margin-top: 26px;
        font-size: 13px;
        color: #98a2b3;
    }
</style>
@endsection

@section('content')
<div class="checkout-auth-page">
    <div class="checkout-auth-card">
        <h1>{!! __('checkout.auth.continue_as_guest') !!}</h1>

        <p>
            {!! __('checkout.auth.login_prompt') !!}
        </p>

        <div class="checkout-auth-actions">
           <a href="{{ route('login', ['redirect' => route('checkout.index')]) }}" class="checkout-auth-btn primary">
    {!! __('checkout.auth.login') !!}
</a>

            <a href="{{ route('checkout.continueGuest') }}" class="checkout-auth-btn outline">
                {!! __('checkout.auth.continue_as_guest') !!}
            </a>
        </div>

        <div class="checkout-auth-note">
            {!! __('checkout.auth.note') !!}
        </div>
    </div>
</div>
@endsection