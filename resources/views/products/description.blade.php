@extends('layouts.app')

@section('title', $product->product_name)

@section('content')

@php
    $mainImage = $product->mainImage;

    $galleryImages = $product->images
        ? $product->images->where('image_type', 'main')->sortBy('sort_order')
        : collect();

    if ($galleryImages->count() === 0 && $product->images) {
        $galleryImages = $product->images->sortBy('sort_order');
    }

    $customizeRoute = '#';

    if ((int) $product->product_type === 1) {
        $customizeRoute = route('products.hotstrap.show', $product->product_id);
    } elseif ((int) $product->product_type === 2) {
        $customizeRoute = route('products.hotmobily.show', $product->product_id);
    }
@endphp

<section class="product-description-page">

    <div class="product-breadcrumb">
        <a href="{{ route('products.index') }}">⌂</a>
        <span>/</span>

        @if($product->category)
            <span>{{ $product->category->category_name }}</span>
            <span>/</span>
        @endif

        <span>{{ $product->product_name }}</span>
    </div>

    <div class="product-description-grid">

        <div class="product-gallery">
            <div class="product-main-image">
                @if($mainImage)
                    <img 
                        id="mainProductImage"
                        src="{{ asset('storage/' . $mainImage->image_path) }}" 
                        alt="{{ $product->product_name }}"
                    >
                @else
                    <img 
                        id="mainProductImage"
                        src="{{ asset('images/no-image.png') }}" 
                        alt="No image"
                    >
                @endif
            </div>

            <div class="product-thumbnails">
                @forelse($galleryImages as $image)
                    <button 
                        type="button" 
                        class="product-thumbnail {{ $loop->first ? 'active' : '' }}"
                        data-image="{{ asset('storage/' . $image->image_path) }}"
                    >
                        <img 
                            src="{{ asset('storage/' . $image->image_path) }}" 
                            alt="{{ $product->product_name }}"
                        >
                    </button>
                @empty
                    <button type="button" class="product-thumbnail active">
                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                    </button>
                @endforelse
            </div>
        </div>

        <div class="product-summary">
            <div class="product-rating-line">
                <span>
                    {{ $product->category->category_name ?? 'Products' }}
                </span>

                <span class="product-stars">
                    ★★★★★
                </span>
            </div>

            <h1>
                {{ $product->product_name }}
            </h1>

            <div class="product-description-text">
                {!! nl2br(e($product->description)) !!}
            </div>

            <a href="{{ $customizeRoute }}" class="customize-btn">
                <span>Personalizar agora</span>
                <span>🛒</span>
            </a>
        </div>

    </div>

</section>

<script>
    document.querySelectorAll('.product-thumbnail').forEach(function (button) {
        button.addEventListener('click', function () {
            const imageUrl = this.dataset.image;

            if (!imageUrl) {
                return;
            }

            document.getElementById('mainProductImage').src = imageUrl;

            document.querySelectorAll('.product-thumbnail').forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');
        });
    });
</script>

@endsection