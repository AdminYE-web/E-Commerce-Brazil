@extends('layouts.app')

@section('title', $product->product_name)

@section('content')

@php
    $mainImage = $product->mainImage;

    $galleryImages = $product->galleryImages ?? collect();

    $detailItems = [];

    if ($product->detail && is_array($product->detail->detail_content)) {
        $detailItems = $product->detail->detail_content;
    }

    $customizeRoute = route('products.hotstrap.show', $product->product_id);
@endphp

<section class="hotstrap-desc-page">

    <div class="hotstrap-container">

        <div class="hotstrap-breadcrumb">
            <a href="{{ route('products.index') }}">⌂</a>
            <span>/</span>

            @if($product->category)
                <span>{{ $product->category->category_name }}</span>
                <span>/</span>
            @endif

            <span>{{ $product->product_name }}</span>
        </div>

        <div class="hotstrap-main-grid">

            <div class="hotstrap-gallery">
               <div class="hotstrap-main-image zoom-box" id="zoomBox">
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

                <div class="hotstrap-thumbnails">
                    @forelse($galleryImages as $image)
                        <button 
                            type="button"
                            class="hotstrap-thumb {{ $loop->first ? 'active' : '' }}"
                            data-image="{{ asset('storage/' . $image->image_path) }}"
                        >
                            <img 
                                src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $product->product_name }}"
                            >
                        </button>
                    @empty
                        <button type="button" class="hotstrap-thumb active">
                            <img src="{{ asset('images/no-image.png') }}" alt="No image">
                        </button>
                    @endforelse
                </div>
            </div>

            <div class="hotstrap-summary">
                <div class="hotstrap-rating">
                    <span>{{ $product->category->category_name ?? 'Lanyards' }}</span>
                    <span class="stars">★★★★★</span>
                </div>

                <h1>{{ $product->product_name }}</h1>

                <div class="hotstrap-description">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <a href="{{ $customizeRoute }}" class="hotstrap-customize-btn">
                    <span>Personalizar agora</span>
                    <span class="cart-icon">🛒</span>
                </a>
            </div>

        </div>

        @if(!empty($detailItems))
            <div class="hotstrap-feature-grid">
                @foreach($detailItems as $item)
                    <div class="hotstrap-feature-card">
                        <div class="feature-icon">
                            {{ $item['emoticon'] ?? '✦' }}
                        </div>

                        <h3>
                            {{ $item['headline'] ?? '' }}
                        </h3>

                        <p>
                            {{ $item['desc'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</section>

<script>
    document.querySelectorAll('.hotstrap-thumb').forEach(function (button) {
        button.addEventListener('click', function () {
            const imageUrl = this.dataset.image;

            if (!imageUrl) {
                return;
            }

            document.getElementById('mainProductImage').src = imageUrl;

            document.querySelectorAll('.hotstrap-thumb').forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');
        });
    });
</script>
<script>
    const mainProductImage = document.getElementById('mainProductImage');
    const zoomBox = document.getElementById('zoomBox');

    if (mainProductImage && zoomBox) {
        zoomBox.addEventListener('mouseenter', function () {
            zoomBox.classList.add('is-zooming');
        });

        zoomBox.addEventListener('mouseleave', function () {
            zoomBox.classList.remove('is-zooming');
            mainProductImage.style.transformOrigin = 'center center';
        });

        zoomBox.addEventListener('mousemove', function (e) {
            const rect = zoomBox.getBoundingClientRect();

            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            mainProductImage.style.transformOrigin = `${x}% ${y}%`;
        });
    }

    document.querySelectorAll('.hotstrap-thumb').forEach(function (button) {
        button.addEventListener('click', function () {
            const imageUrl = this.dataset.image;

            if (!imageUrl) {
                return;
            }

            mainProductImage.src = imageUrl;

            document.querySelectorAll('.hotstrap-thumb').forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');
        });
    });
</script>

@endsection