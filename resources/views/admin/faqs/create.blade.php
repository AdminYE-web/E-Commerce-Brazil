@extends('admin.layouts.app')

@section('title', 'Create FAQ | Indigo Admin')

@include('admin.faqs._style')

@section('content')

<form action="{{ route('admin.faqs.store') }}" method="POST">
    @csrf

    <div class="table-card faq-page-card">
        <div class="table-header">
            <div>
                <div class="table-title">Create FAQ</div>
                <div class="showing-text">Current language: {{ strtoupper($language) }}</div>
            </div>

            <a href="{{ route('admin.faqs.index') }}" class="btn-outline">Back</a>
        </div>

        @include('admin.faqs._form')

        <div class="faq-actions-bottom">
            <button type="submit" class="faq-save-btn">
                Save FAQ
            </button>

            <a href="{{ route('admin.faqs.index') }}" class="faq-cancel-btn">
                Cancel
            </a>
        </div>
    </div>
</form>

@endsection