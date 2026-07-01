@extends('layouts.app')

@section('title', $product->product_name)

@section('css')
    <style>
        .product-faq-section {
            background: #f5f7fb;
            padding: 44px 16px 56px;
        }

        .product-faq-wrap {
            max-width: 1180px;
            margin: 0 auto;
        }

        .product-faq-title {
            margin: 0 0 18px;
            color: #111;
            font-size: 24px;
            font-weight: 900;
        }

        .product-faq-box {
            background: #fff;
            border: 1px solid #cfd4dc;
            border-radius: 8px;
            padding: 18px 22px;
        }

        .product-faq-item {
            border-bottom: 1px solid #edf0f4;
            padding: 12px 0;
        }

        .product-faq-item:last-child {
            border-bottom: 0;
        }

        .product-faq-question {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 0;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            text-align: left;
            cursor: pointer;
            color: #111;
        }

        .product-faq-question-text {
            font-size: 15px;
            font-weight: 900;
            line-height: 1.45;
        }

        .product-faq-icon {
            font-size: 18px;
            line-height: 1;
            transition: transform .25s ease;
        }

        .product-faq-item.is-open .product-faq-icon {
            transform: rotate(180deg);
        }

        .product-faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .28s ease;
        }

        .product-faq-answer-inner {
            padding: 10px 32px 0 14px;
            color: #111;
            font-size: 13px;
            line-height: 1.55;
            white-space: pre-line;
        }

        @media (max-width: 768px) {
            .product-faq-section {
                padding: 34px 16px 44px;
            }

            .product-faq-title {
                font-size: 22px;
            }

            .product-faq-box {
                padding: 14px 16px;
            }
        }

        .translation-alert-popup {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(15, 23, 42, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .translation-alert-box {
            width: min(100%, 420px);
            background: #fff;
            border-radius: 14px;
            padding: 26px 24px;
            text-align: center;
            box-shadow: 0 20px 55px rgba(0, 0, 0, 0.22);
        }

        .translation-alert-box h3 {
            margin: 0 0 10px;
            font-size: 20px;
            font-weight: 800;
            color: #111827;
        }

        .translation-alert-box p {
            margin: 0 0 20px;
            font-size: 14px;
            line-height: 1.55;
            color: #4b5563;
        }

        .translation-alert-btn {
            border: 0;
            border-radius: 999px;
            background: #2563eb;
            color: #fff;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }
       .preview-watermark {
    position: fixed;
    inset: 0;
    z-index: 99998;
    pointer-events: none;
    overflow: hidden;
}

.preview-watermark::before {
    content: "PREVIEW";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-28deg);
    font-size: clamp(72px, 14vw, 180px);
    font-weight: 900;
    letter-spacing: 10px;
    color: rgba(220, 38, 38, 0.12);
    white-space: nowrap;
    text-transform: uppercase;
}
.preview-watermark-close-btn {
    position: fixed;
    top: 90px;
    right: 24px;
    z-index: 100000;
    border: 0;
    border-radius: 999px;
    background: #111827;
    color: #fff;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
}

.preview-watermark-close-btn:hover {
    background: #000;
}

.preview-watermark-hidden {
    display: none !important;
}
    </style>
@endsection

@section('content')

  @if ($isPreview ?? false)
    <div id="previewWatermark" class="preview-watermark"></div>

    <button type="button" id="previewWatermarkClose" class="preview-watermark-close-btn">
        Hide Preview
    </button>
@endif

    @php
        $mainImage = $product->mainImage;

        $galleryImages = $product->galleryImages ?? collect();

        $detailItems = [];

        if ($product->detail && is_array($product->detail->detail_content)) {
            $detailItems = $product->detail->detail_content;
        }

        $customizeRoute = route('products.order', $product->product_code);

        $specItems = [];

        if ($product->detail && is_array($product->detail->specification_content)) {
            $specItems = $product->detail->specification_content;
        }

        $accordionItems = [];

        if ($product->detail && is_array($product->detail->accordion_content)) {
            $accordionItems = $product->detail->accordion_content;
        }
    @endphp
    @if (session('translation_unavailable'))
        <div class="translation-alert-popup" id="translationAlertPopup">
            <div class="translation-alert-box">
                <h3>Translation unavailable</h3>
                <p>{{ session('translation_unavailable') }}</p>

                <button type="button" class="translation-alert-btn" id="translationAlertClose">
                    OK
                </button>
            </div>
        </div>
    @endif

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
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $product->product_name }}">
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
                        <span>{{ __('product.product_description.go_order') }}</span>
                        <img src="{{ asset('assets/images/icon/Vector (5).png') }}" alt="">
                    </a>
                </div>

            </div>

         @php
    $visibleDetailItems = collect($detailItems ?? [])
        ->filter(function ($item) {
            return !empty($item['title'])
                || !empty($item['headline'])
                || !empty($item['desc'])
                || !empty($item['icon_image']);
        });
@endphp

@if ($visibleDetailItems->isNotEmpty())
    <div class="hotstrap-feature-grid">
        @foreach ($visibleDetailItems as $item)
            <div class="hotstrap-feature-card">
                <div class="feature-icon">
                    @if (!empty($item['icon_image']))
                        <img src="{{ asset('storage/' . $item['icon_image']) }}"
                            alt="{{ $item['title'] ?? $item['headline'] ?? '' }}">
                    @else
                        ✦
                    @endif
                </div>

                @if (!empty($item['title']) || !empty($item['headline']))
                    <h3>{{ $item['title'] ?? $item['headline'] }}</h3>
                @endif

                @if (!empty($item['desc']))
                    <p>{{ $item['desc'] }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endif

        </div>

    </section>

    @if ($product->detail && ($product->detail->specification_image || !empty($specItems)))
        <section class="hotstrap-spec-section">
            <div class="hotstrap-spec-grid">



                <div class="hotstrap-spec-content">
                    <h2>{{ __('product_desc.product_desc.product_details') }}</h2>

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
                <div class="hotstrap-spec-image">
                    @if ($product->detail->specification_image)
                        <img src="{{ asset('storage/' . $product->detail->specification_image) }}"
                            alt="{{ $product->product_name }}">
                    @endif
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
    @if (isset($productFaqs) && $productFaqs->count())
        <section class="product-faq-section">
            <div class="product-faq-wrap">
                <h2 class="product-faq-title">FAQ</h2>

                <div class="product-faq-box">
                    @foreach ($productFaqs as $faq)
                        <div class="product-faq-item {{ $loop->first ? 'is-open' : '' }}">
                            <button type="button" class="product-faq-question">
                                <span class="product-faq-question-text">
                                    Q{{ $loop->iteration }} : {{ $faq->question }}
                                </span>

                                <span class="product-faq-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </button>

                            <div class="product-faq-answer" style="{{ $loop->first ? 'max-height: 500px;' : '' }}">
                                <div class="product-faq-answer-inner">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if (isset($relatedProducts) && $relatedProducts->count())
        <section class="recommended-section" style="background: #F8F9FB;">


            <div class="container recommended-container">
                <div class="recommended-title">
                    <h2>
                        {{ __('product_desc.product_desc.you_may_also_like') }}

                    </h2>
                </div>

                <div class="recommended-slider-wrap">
                    <div class="swiper recommended-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($relatedProducts as $relatedProduct)
                                <div class="swiper-slide">

                                    <div class="recommended-card">
                                        <a href="{{ route('products.description', $relatedProduct->product_code) }}"
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
                                                @if ($relatedProduct->mainImage)
                                                    <img src="{{ asset('storage/' . $relatedProduct->mainImage->image_path) }}"
                                                        alt="{{ $relatedProduct->product_name }}">
                                                @else
                                                    <img src="{{ asset('images/no-image.png') }}" alt="No image">
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
    <script>
        document.querySelectorAll('.product-faq-question').forEach(function(button) {
            button.addEventListener('click', function() {
                const item = this.closest('.product-faq-item');
                const answer = item.querySelector('.product-faq-answer');
                const isOpen = item.classList.contains('is-open');

                document.querySelectorAll('.product-faq-item').forEach(function(otherItem) {
                    otherItem.classList.remove('is-open');

                    const otherAnswer = otherItem.querySelector('.product-faq-answer');

                    if (otherAnswer) {
                        otherAnswer.style.maxHeight = null;
                    }
                });

                if (!isOpen) {
                    item.classList.add('is-open');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('translationAlertPopup');
            const closeBtn = document.getElementById('translationAlertClose');

            if (popup && closeBtn) {
                closeBtn.addEventListener('click', function() {
                    popup.remove();
                });
            }
        });
    </script>
    @if ($isPreview ?? false)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const watermark = document.getElementById('previewWatermark');
            const closeBtn = document.getElementById('previewWatermarkClose');

            if (!closeBtn) {
                return;
            }

            closeBtn.addEventListener('click', function () {
                if (watermark) {
                    watermark.classList.add('preview-watermark-hidden');
                }

                closeBtn.classList.add('preview-watermark-hidden');
            });
        });
    </script>
@endif
@endsection
