@extends('admin.layouts.app')

@section('title', 'Edit FAQ | Indigo Admin')

@include('admin.faqs._style')

@section('content')

<form action="{{ route('admin.faqs.update', $faq->faq_id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="table-card faq-page-card">
        <div class="table-header">
            <div>
                <div class="table-title">Edit FAQ</div>
                <div class="showing-text">{{ $faq->question }}</div>
            </div>

            <a href="{{ route('admin.faqs.index') }}" class="btn-outline">Back</a>
        </div>

        @include('admin.faqs._form', ['faq' => $faq])

        <div class="faq-actions-bottom">
            <button type="submit" class="faq-save-btn">
                Update FAQ
            </button>

            <a href="{{ route('admin.faqs.index') }}" class="faq-cancel-btn">
                Cancel
            </a>
        </div>
    </div>
</form>

@endsection