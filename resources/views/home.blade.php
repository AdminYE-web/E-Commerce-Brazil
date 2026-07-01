@extends('layouts.app')

@section('title', __('messages.home.page_title'))


@section('css')
    <style>
        .container-banner {
            width: 90%;
            margin: 0 auto;
        }

        .home-banner-section .carousel-item img {

            object-fit: cover;
        }

        .home-banner-section .carousel-control-prev,
        .home-banner-section .carousel-control-next {
            width: 44px;
            height: 44px;
            top: 50%;
            bottom: auto;
            transform: translateY(-50%);
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.38);
            opacity: 1;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .home-banner-section .carousel-control-prev {
            left: 18px;
        }

        .home-banner-section .carousel-control-next {
            right: 18px;
        }

        .home-banner-section .carousel-control-prev:hover,
        .home-banner-section .carousel-control-next:hover {
            background: rgba(0, 0, 0, 0.56);
            transform: translateY(-50%) scale(1.04);
        }

        .home-banner-section .carousel-control-prev-icon,
        .home-banner-section .carousel-control-next-icon {
            width: 18px;
            height: 18px;
            filter: brightness(0) invert(1);
        }

        @media (max-width: 768px) {
            .home-banner-section .carousel-item img {}

            .home-banner-section .carousel-control-prev,
            .home-banner-section .carousel-control-next {
                width: 38px;
                height: 38px;
            }

            .home-banner-section .carousel-control-prev {
                left: 10px;
            }

            .home-banner-section .carousel-control-next {
                right: 10px;
            }
        }
    </style>
@endsection
@section('content')
    {{-- <section class="hero-banner">
        <div class="container-fluid p-0">
            <div id="homeBannerCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">

                <div class="carousel-inner">

                    <!-- Banner 1 -->
                    <div class="carousel-item active">
                        <div class="hero-slide">

                            <div class="hero-copy">
                                <h1 class="hero-title">
                                    {{ __('messages.home.banner1_title_line1') }} <br>
                                    {{ __('messages.home.banner1_title_line2') }} <br>
                                    {{ __('messages.home.banner1_title_line3') }}
                                </h1>

                                <p class="hero-text">
                                    {{ __('messages.home.banner1_text') }}
                                </p>

                                <div class="hero-action-group">
                                    <div class="hero-dots-custom">
                                        <button class="active" type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="0"></button>
                                        <button type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="1"></button>
                                    </div>

                                    <a href="#" class="btn hero-cta">
                                        <span>{{ __('messages.home.view_catalog') }}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <img src="{{ asset('assets/images/home/banner_home_v2.png') }}" alt="Banner Home"
                                class="hero-banner-image">

                        </div>
                    </div>

                    <!-- Banner 2 -->
                    <div class="carousel-item">
                        <div class="hero-slide" style="background: #F5CF3C">

                            <div class="hero-copy">
                                <h1 class="hero-head" style="color: black">HOTMOBILY</h1>
                                <h1 class="hero-title" style="color: black">
                                    {{ __('messages.home.banner2_title') }}
                                </h1>

                                <p class="hero-text" style="color: black">
                                    {{ __('messages.home.banner2_text') }}
                                </p>

                                <div class="hero-action-group">
                                    <div class="hero-dots-custom">
                                        <button type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="0"></button>
                                        <button class="active" type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="1"></button>
                                    </div>

                                    <a href="#" class="btn hero-cta" style="background: white; color: black">
                                        <span>{{ __('messages.home.view_catalog') }}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <img src="{{ asset('assets/images/home/banner_home_2_v2.png') }}" alt="Banner Home 2"
                                class="hero-banner-image">

                        </div>
                    </div>

                </div>

                <button class="carousel-control-prev hero-control hero-control-prev-custom" type="button"
                    data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
                    <span class="hero-control-icon" aria-hidden="true">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next hero-control hero-control-next-custom" type="button"
                    data-bs-target="#homeBannerCarousel" data-bs-slide="next">
                    <span class="hero-control-icon" aria-hidden="true">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </div>
    </section> --}}
    @if ($homeBanners->count())
        <section class="home-banner-section">
            <div class="container-fluid p-0 ">

                <div id="homeBannerCarousel" class="carousel slide" data-bs-ride="carousel">

                    @if ($homeBanners->count() > 1)
                        <div class="carousel-indicators">
                            @foreach ($homeBanners as $index => $banner)
                                <button type="button" data-bs-target="#homeBannerCarousel"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif

                    <div class="carousel-inner rounded-4 overflow-hidden">

                        @foreach ($homeBanners as $index => $banner)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                                @php
                                    $pcImage = $banner->image_pc
                                        ? asset('storage/' . $banner->image_pc)
                                        : asset('images/no-image.png');

                                    $mobileImage = $banner->image_mobile
                                        ? asset('storage/' . $banner->image_mobile)
                                        : $pcImage;
                                @endphp

                                @if ($banner->link_url)
                                    <a href="{{ $banner->link_url }}">
                                @endif

                                <picture>
                                    {{-- มือถือ + iPad ใช้รูป mobile --}}
                                    <source media="(max-width: 1024px)" srcset="{{ $mobileImage }}">

                                    {{-- Desktop ใช้รูป PC --}}
                                    <img src="{{ $pcImage }}" class="d-block w-100 home-banner-img"
                                        alt="{{ $banner->title ?? 'Home Banner' }}">
                                </picture>

                                @if ($banner->link_url)
                                    </a>
                                @endif

                            </div>
                        @endforeach

                    </div>

                    @if ($homeBanners->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif

                </div>

            </div>
        </section>
    @endif
    <section class="feature-bar">
        <div class="container-fluid">
            <div class="feature-bar-inner">

                <div class="feature-item">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/images/home/hugeicons_checkmark-square-04.png') }}" alt="Pedido fácil">
                    </div>
                    <div class="feature-text">{{ __('messages.home.feature_easy_order') }}</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/images/home/Icon.png') }}" alt="Preços mais baixos">
                    </div>
                    <div class="feature-text">{{ __('messages.home.feature_lowest_prices') }}</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/images/home/material-symbols-light_delivery-truck-speed-outline.png') }}"
                            alt="Entrega expressa rápida">
                    </div>
                    <div class="feature-text">{{ __('messages.home.feature_fast_delivery') }}</div>
                </div>

            </div>
        </div>
    </section>
    <section class="recommended-section">
        <div class="recommended-bg recommended-bg-up"></div>
        <div class="recommended-bg recommended-bg-left"></div>
        <div class="recommended-bg recommended-bg-right-big"></div>
        <div class="recommended-bg recommended-bg-right-small"></div>

        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    {{ __('messages.home.recommended_title') }}
                    <span>{{ __('messages.home.recommended_subtitle') }}</span>
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">

                        @forelse($recommendedProducts as $product)
                            @php
                                $productImage = $product->mainImage?->image_path;
                            @endphp

                            <div class="swiper-slide">
                                <a href="{{ route('products.description', ['code' => $product->product_code]) }}"
                                    class="recommended-card-link">
                                    <div class="recommended-card">
                                        <h3>{{ $product->product_name }}</h3>

                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>

                                        <div class="product-img-wrap">
                                            @if ($productImage)
                                                <img src="{{ asset('storage/' . $productImage) }}"
                                                    alt="{{ $product->product_name }}">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="recommended-card">
                                    <h3>No recommended products</h3>

                                    <div class="product-img-wrap">
                                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="purchase-steps-section">
        <div class="step-pattern step-pattern-left"></div>
        <div class="step-pattern step-pattern-right"></div>

        <div class="container">
            <div class="purchase-steps-title">
                <h2>{{ __('messages.home.steps_title') }}</h2>
            </div>

            <div class="purchase-steps-wrapper">

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">1</span>
                        <img src="{{ asset('assets/images/home/step-1.png') }}" alt="Choose and customize product">
                    </div>
                    <div class="step-text">
                        {{ __('messages.home.step1_text') }}
                    </div>
                </div>

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">2</span>
                        <img src="{{ asset('assets/images/home/step-2.png') }}" alt="Add to cart">
                    </div>
                    <div class="step-text">
                        {{ __('messages.home.step2_text') }}
                    </div>
                </div>

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">3</span>
                        <img src="{{ asset('assets/images/home/step-3.png') }}" alt="Confirm order and payment">
                    </div>
                    <div class="step-text">
                        {{ __('messages.home.step3_text') }}
                    </div>
                </div>

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">4</span>
                        <img src="{{ asset('assets/images/home/step-4.png') }}" alt="Receive product">
                    </div>
                    <div class="step-text">
                        {{ __('messages.home.step4_text') }}
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="recommended-section">


        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    {{ __('messages.home.lanyards_title') }}
                    <span>{{ __('messages.home.lanyards_subtitle') }}</span>
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">

                        @forelse($recommendedType1Products as $product)
                            @php
                                $productImage = $product->mainImage?->image_path;
                            @endphp

                            <div class="swiper-slide">
                                <a href="{{ route('products.description', ['code' => $product->product_code]) }}"
                                    class="recommended-card-link">
                                    <div class="recommended-card">
                                        <h3>{{ $product->product_name }}</h3>

                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>

                                        <div class="product-img-wrap">
                                            @if ($productImage)
                                                <img src="{{ asset('storage/' . $productImage) }}"
                                                    alt="{{ $product->product_name }}">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="recommended-card">
                                    <h3>No recommended products</h3>

                                    <div class="product-img-wrap">
                                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- <div class="recommended-swiper-pagination"></div> --}}
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn hero-cta">
                    <span>{{ __('messages.home.view_more') }}</span>
                </a>
            </div>
        </div>
    </section>
    <section class="promotional-steps-section">


        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    {{ __('messages.home.promotional_title') }}
                    <span>{{ __('messages.home.promotional_subtitle') }}</span>
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">

                        @forelse($recommendedType2Products as $product)
                            @php
                                $productImage = $product->mainImage?->image_path;
                            @endphp

                            <div class="swiper-slide">
                                <a href="{{ route('products.description', ['code' => $product->product_code]) }}"
                                    class="recommended-card-link">
                                    <div class="recommended-card">
                                        <h3>{{ $product->product_name }}</h3>

                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>

                                        <div class="product-img-wrap">
                                            @if ($productImage)
                                                <img src="{{ asset('storage/' . $productImage) }}"
                                                    alt="{{ $product->product_name }}">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="recommended-card">
                                    <h3>No recommended products</h3>

                                    <div class="product-img-wrap">
                                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- <div class="recommended-swiper-pagination"></div> --}}
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn hero-cta">
                    <span>{{ __('messages.home.view_more') }}</span>
                </a>
            </div>
        </div>
    </section>
    <section class="premium-materials-section premium-materials-desktop">
        <div class="container">
            <div class="premium-materials-header">
                <h2>{{ __('messages.home.materials_title') }}</h2>
                <p>
                    {{ __('messages.home.materials_description') }}
                </p>
            </div>

            <div class="materials-grid">
                @foreach ($materialHomes as $item)
                    <div class="material-card">
                        <div class="material-image">
                            <a href="{{ route('products.index', [
    'product_type' => $item->product_type,
    'materials' => [$item->material_id],
]) }}"><img
                                    src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}"></a>

                        </div>
                        <div class="material-content">
                            <h3>{{ $item->title }}</h3>
                            <p>
                                {{ $item->description }}
                            </p>
                        </div>
                    </div>
                @endforeach


                <div class="material-card material-card-wide">
                    <div class="material-image">
                        <a href="{{ route('products.index') }}">
                            <img src="{{ asset('assets/images/home/material-other.png') }}" alt="Other Materials">
                        </a>
                    </div>
                    <div class="material-content">
                        <h3>{{ __('messages.home.material_other') }}</h3>
                        <p>{{ __('messages.home.material_other_desc') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="premium-materials-section premium-materials-mobile">
        <div class="container">
            <div class="premium-materials-header">
                <h2>{{ __('messages.home.materials_title') }}</h2>
                <p>
                    {{ __('messages.home.materials_description') }}
                </p>
            </div>

            <div class="swiper premium-materials-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-rubber-pvc.png') }}" alt="Rubber & PVC">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_rubber_pvc') }}</h3>
                                <p>{{ __('messages.home.material_rubber_pvc_desc') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-acrylic.png') }}" alt="Acrylic">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_acrylic') }}</h3>
                                <p>{{ __('messages.home.material_acrylic_desc') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-textile.png') }}" alt="Textile">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_textile') }}</h3>
                                <p>{{ __('messages.home.material_textile_desc') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-polyester.png') }}" alt="Polyester">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_polyester') }}</h3>
                                <p>{{ __('messages.home.material_polyester_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-sublimation.png') }}" alt="Sublimation">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_sublimation') }}</h3>
                                <p>{{ __('messages.home.material_sublimation_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-nylon.png') }}" alt="Nylon">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_nylon') }}</h3>
                                <p>{{ __('messages.home.material_nylon_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-other.png') }}" alt="Other Materials">
                            </div>
                            <div class="material-content">
                                <h3>{{ __('messages.home.material_other') }}</h3>
                                <p>{{ __('messages.home.material_other_desc') }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <div class="premium-materials-pagination"></div> --}}
            </div>
        </div>
    </section>
    <section class="blog-inspirations-section">
        <div class="container">
            <div class="blog-inspirations-header">
                <h2>{{ __('messages.home.blog_title') }}</h2>
            </div>

            <div class="blog-swiper-wrap">
                <div class="swiper blog-swiper">
                    <div class="swiper-wrapper">

                        @forelse($homeArticles as $article)
                            <div class="swiper-slide">
                                <article class="blog-card">
                                    <a href="{{ route('blog.show', $article->article_id) }}" class="blog-image">
                                        @if ($article->cover_image)
                                            <img src="{{ asset('storage/' . $article->cover_image) }}"
                                                alt="{{ $article->title }}">
                                        @else
                                            <img src="{{ asset('assets/images/home/blog-1.png') }}"
                                                alt="{{ $article->title }}">
                                        @endif
                                    </a>

                                    <div class="blog-content">
                                        <h3>{{ $article->title }}</h3>
                                        <p>
                                            {{ \Illuminate\Support\Str::limit($article->description ?: strip_tags($article->detail ?? ''), 140) }}
                                        </p>

                                        <div class="blog-meta">
                                            <span
                                                class="blog-tag {{ $loop->even ? 'blog-tag-yellow' : 'blog-tag-blue' }}">
                                                {{ $article->category ?? __('messages.home.blog_tag_brindes') }}
                                            </span>
                                            <span class="blog-date">
                                                {{ $article->article_date ? \Carbon\Carbon::parse($article->article_date)->format('d/m/Y') : $article->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <article class="blog-card">
                                    <a href="{{ route('blog.index') }}" class="blog-image">
                                        <img src="{{ asset('assets/images/home/blog-1.png') }}" alt="Blog">
                                    </a>

                                    <div class="blog-content">
                                        <h3>Teste</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua.
                                        </p>

                                        <div class="blog-meta">
                                            <span
                                                class="blog-tag blog-tag-blue">{{ __('messages.home.blog_tag_brindes') }}</span>
                                            <span class="blog-date">24/04/2026</span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforelse

                    </div>
                </div>

                <div class="blog-swiper-pagination"></div>
            </div>

            <div class="blog-button-wrap">
                <a href="{{ route('blog.index') }}"
                    class="blog-more-btn">{{ __('messages.home.blog_explore_more') }}</a>
            </div>
        </div>
    </section>


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
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.premium-materials-swiper', {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: false,
                speed: 500,

                pagination: {
                    el: '.premium-materials-swiper-pagination',
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
    {{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    let premiumMaterialsSwiper = null;

    function initPremiumMaterialsSwiper() {
        const isMobile = window.innerWidth <= 767;

        if (isMobile && premiumMaterialsSwiper === null) {
            premiumMaterialsSwiper = new Swiper('.premium-materials-swiper', {
                slidesPerView: 1.25,
                spaceBetween: 12,
                speed: 500,
                pagination: {
                    el: '.premium-materials-pagination',
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
        }

        if (!isMobile && premiumMaterialsSwiper !== null) {
            premiumMaterialsSwiper.destroy(true, true);
            premiumMaterialsSwiper = null;
        }
    }

    initPremiumMaterialsSwiper();
    window.addEventListener('resize', initPremiumMaterialsSwiper);
});
</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let blogSwiper = null;

            function initBlogSwiper() {
                const isMobile = window.innerWidth < 768;

                if (isMobile && blogSwiper === null) {
                    blogSwiper = new Swiper('.blog-swiper', {
                        slidesPerView: 1.2,
                        spaceBetween: 14,
                        speed: 500,
                        pagination: {
                            el: '.blog-swiper-pagination',
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
                }

                if (!isMobile && blogSwiper !== null) {
                    blogSwiper.destroy(true, true);
                    blogSwiper = null;
                }
            }

            initBlogSwiper();
            window.addEventListener('resize', initBlogSwiper);
        });
    </script>
@endsection
