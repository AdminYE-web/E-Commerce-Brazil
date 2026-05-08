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

        if ($product->product_type == PRODUCT_HOTSTRAP) {
            $customizeRoute = route('products.order', $product->product_code);
        } elseif ($product->product_type == PRODUCT_HOTMOBILY) {
            $customizeRoute = route('products.order', $product->product_code);
        }

        $specItems = [];

        if ($product->detail && is_array($product->detail->specification_content)) {
            $specItems = $product->detail->specification_content;
        }

        $accordionItems = [];

        if ($product->detail && is_array($product->detail->accordion_content)) {
            $accordionItems = $product->detail->accordion_content;
        }
    @endphp

    <section class="hotstrap-desc-page">

        <div class="hotstrap-container">

            <div class="hotstrap-breadcrumb">
                <a href="{{ route('products.index') }}"><img src="{{ asset('assets/images/icon/home.png') }}"
                        alt="Home"></a>
                <span>/</span>

                @if ($product->category)
                    <span>{{ $product->category->category_name }}</span>
                    <span>/</span>
                @endif

                <span>{{ $product->product_name }}</span>
            </div>

            <div class="hotstrap-main-grid">

                <div class="hotstrap-gallery">
                    <div class="hotstrap-main-image zoom-box" id="zoomBox">
                        @if ($mainImage)
                            <img id="mainProductImage" src="{{ asset('storage/' . $mainImage->image_path) }}"
                                alt="{{ $product->product_name }}">
                        @else
                            <img id="mainProductImage" src="{{ asset('images/no-image.png') }}" alt="No image">
                        @endif
                    </div>

                    <div class="hotstrap-thumbnails">
                        @forelse($galleryImages as $image)
                            <button type="button" class="hotstrap-thumb {{ $loop->first ? 'active' : '' }}"
                                data-image="{{ asset('storage/' . $image->image_path) }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->product_name }}">
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
                        <img src="{{ asset('assets/images/icon/Vector (5).png') }}" alt="">
                    </a>
                </div>

            </div>

            @if (!empty($detailItems))
                <div class="hotstrap-feature-grid">
                    @foreach ($detailItems as $item)
                        <div class="hotstrap-feature-card">
                            <div class="feature-icon">
                                @if (!empty($item['icon_image']))
                                    <img src="{{ asset('storage/' . $item['icon_image']) }}"
                                        alt="{{ $item['headline'] ?? '' }}">
                                @else
                                    ✦
                                @endif
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

    @if ($product->detail && ($product->detail->specification_image || !empty($specItems)))
        <section class="hotstrap-spec-section">
            <div class="hotstrap-spec-grid">

                <div class="hotstrap-spec-image">
                    @if ($product->detail->specification_image)
                        <img src="{{ asset('storage/' . $product->detail->specification_image) }}"
                            alt="{{ $product->product_name }}">
                    @endif
                </div>

                <div class="hotstrap-spec-content">
                    <h2>Product Details</h2>

                    <div class="hotstrap-spec-card">
                        @foreach ($specItems as $item)
                            <div class="hotstrap-spec-row">
                                <div class="hotstrap-spec-icon">
                                    @if (!empty($item['icon_image']))
                                        <img src="{{ asset('storage/' . $item['icon_image']) }}"
                                            alt="{{ $item['title'] ?? '' }}">
                                    @else
                                        ✦
                                    @endif
                                </div>

                                <div>
                                    <h3>{{ $item['title'] ?? '' }}</h3>
                                    <p>
                                        {{ $item['desc'] ?? '' }}

                                        @if (!empty($item['link_url']))
                                            <a href="{{ $item['link_url'] }}"
                                                target="{{ str_starts_with($item['link_url'], 'http') ? '_blank' : '_self' }}"
                                                rel="noopener">
                                                {{ $item['link_text'] ?? 'View more' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </section>

    @endif

    @if (!empty($accordionItems))
        <section class="hotstrap-accordion-section">
            <div class="hotstrap-accordion-wrap">
                @foreach ($accordionItems as $index => $item)
                    <div class="custom-accordion-item">
                        <button type="button" class="custom-accordion-header"
                            data-target="accordion-body-{{ $index }}">
                            <span class="custom-accordion-title">
                                {{ $item['title'] ?? '' }}
                            </span>

                            <span class="custom-accordion-icon">+</span>
                        </button>

                        <div class="custom-accordion-body" id="accordion-body-{{ $index }}">
                            <div class="custom-accordion-inner">
                                {!! $item['content'] ?? '' !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    @if (isset($relatedProducts) && $relatedProducts->count())
        <section class="recommended-section" style="background: #F8F9FB;">


        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    Você também pode gostar
                    
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="swiper-slide">

                                <div class="recommended-card">
                                    <a href="{{ route('products.description', $relatedProduct->product_id) }}"
                                        class="no-underline">
                                        <h3>{{ $relatedProduct->product_name }}</h3>

                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>

                                        <div class="product-img-wrap">
    @if($relatedProduct->mainImage)
        <img 
            src="{{ asset('storage/' . $relatedProduct->mainImage->image_path) }}"
            alt="{{ $relatedProduct->product_name }}"
        >
    @else
        <img 
            src="{{ asset('images/no-image.png') }}"
            alt="No image"
        >
    @endif
</div>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

                {{-- <div class="recommended-swiper-pagination"></div> --}}
            </div>
        </div>
    </section>
    @endif
    

    <script>
        document.querySelectorAll('.hotstrap-thumb').forEach(function(button) {
            button.addEventListener('click', function() {
                const imageUrl = this.dataset.image;

                if (!imageUrl) {
                    return;
                }

                document.getElementById('mainProductImage').src = imageUrl;

                document.querySelectorAll('.hotstrap-thumb').forEach(function(item) {
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
            zoomBox.addEventListener('mouseenter', function() {
                zoomBox.classList.add('is-zooming');
            });

            zoomBox.addEventListener('mouseleave', function() {
                zoomBox.classList.remove('is-zooming');
                mainProductImage.style.transformOrigin = 'center center';
            });

            zoomBox.addEventListener('mousemove', function(e) {
                const rect = zoomBox.getBoundingClientRect();

                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                mainProductImage.style.transformOrigin = `${x}% ${y}%`;
            });
        }

        document.querySelectorAll('.hotstrap-thumb').forEach(function(button) {
            button.addEventListener('click', function() {
                const imageUrl = this.dataset.image;

                if (!imageUrl) {
                    return;
                }

                mainProductImage.src = imageUrl;

                document.querySelectorAll('.hotstrap-thumb').forEach(function(item) {
                    item.classList.remove('active');
                });

                this.classList.add('active');
            });
        });
    </script>
    <script>
        document.querySelectorAll('.custom-accordion-header').forEach(function(button) {
            button.addEventListener('click', function() {
                const item = this.closest('.custom-accordion-item');
                const body = item.querySelector('.custom-accordion-body');
                const icon = item.querySelector('.custom-accordion-icon');
                const isActive = item.classList.contains('active');

                // ปิดอันอื่นทั้งหมดก่อน
                document.querySelectorAll('.custom-accordion-item').forEach(function(otherItem) {
                    otherItem.classList.remove('active');

                    const otherBody = otherItem.querySelector('.custom-accordion-body');
                    const otherIcon = otherItem.querySelector('.custom-accordion-icon');

                    otherBody.style.maxHeight = null;
                    otherIcon.textContent = '+';
                });

                // ถ้าอันนี้ยังไม่เปิด ให้เปิด
                if (!isActive) {
                    item.classList.add('active');
                    body.style.maxHeight = body.scrollHeight + 'px';
                    icon.textContent = '−';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.recommended-swiper', {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: false,
                speed: 500,

                pagination: {
                    el: '.recommended-swiper-pagination',
                    clickable: true,
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1.5,
                        spaceBetween: 16,
                    },
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    }
                }
            });
        });
    </script>
@endsection
