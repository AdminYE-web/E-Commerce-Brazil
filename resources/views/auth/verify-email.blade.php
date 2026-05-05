@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-3">Verify your email</h1>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <p>
        We have sent a verification link to your email address.
        Please check your inbox and click the link to verify your account.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-dark">
            Resend verification email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-outline-secondary">
            Logout
        </button>
    </form>
</div>
@endsection