@extends('layouts.app')

@section('title', 'Products')
@section('css')
    <style>
        .pl-category-section {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
            padding: 28px 0;
            background: #fff;
        }

        .pl-category-inner {
            width: min(100% - 32px, 1200px);
            margin: 0 auto;
            overflow: hidden;
        }

        .pl-category-inner h2 {
            margin: 0 0 20px;
            font-size: 28px;
            font-weight: 700;
            color: #111;
        }

        .pl-category-swiper {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .pl-category-swiper .swiper-wrapper {
            align-items: stretch;
        }

        .pl-category-swiper .swiper-slide {
            height: auto;
        }

        .pl-category-btn {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 0;
            text-align: center;
            cursor: pointer;
        }

        .pl-category-img {
            width: 110px;
            height: 110px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pl-category-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pl-category-name {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #111;
            line-height: 1.25;
        }

        .pl-category-btn.active .pl-category-img {
            outline: 3px solid #1f4bbb;
        }

        @media (max-width: 768px) {
            .pl-category-img {
                width: 77%;
                height: 50%;
            }

            .pl-category-section {
                padding: 20px 0;
            }

            .pl-category-inner {
                width: 100%;
                padding: 0 16px;
            }

            .pl-category-inner h2 {
                font-size: 22px;
                margin-bottom: 14px;
            }

            .pl-category-name {
                font-size: 12px;
            }
        }

        .mobile-filter-bar,
        .mobile-filter-header,
        .mobile-apply-filter,
        .mobile-filter-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            .mh-product {
                min-height: 73px;
            }

            .mobile-filter-bar {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding: 12px 0;
                background: #fff;
            }

            .mobile-filter-open {
                width: auto;
                min-height: 32px;
                border: 0;
                border-radius: 0;
                background: #fff;
                color: #111;
                font-size: 14px;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                justify-content: flex-start;
                gap: 8px;
                padding: 0;
            }

            .mobile-filter-open i {
                font-size: 18px;
                line-height: 1;
            }

            .mobile-product-count {
                font-size: 13px;
                color: #111;
                white-space: nowrap;
            }

            .product-page {
                display: block;
            }

            .filter-box {
                position: fixed;
                top: 0;
                right: 0;
                width: 100%;
                max-width: 100%;
                height: 100vh;
                background: #fff;
                z-index: 9999;
                padding: 67px 20px 90px;
                overflow-y: auto;
                transform: translateX(100%);
                transition: transform 0.35s ease;
                box-shadow: -8px 0 24px rgba(0, 0, 0, 0.12);
            }

            .filter-box.is-open {
                transform: translateX(0);
            }

            .mobile-filter-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.35);
                z-index: 9998;
            }

            .mobile-filter-overlay.is-open {
                display: block;
            }

            .mobile-filter-header {
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                align-items: center;
                padding: 6px 0 18px;
                background: #fff;
                position: sticky;
                top: 0;
                z-index: 2;
            }

            .mobile-filter-header h3 {
                margin: 0;
                font-size: 24px;
                font-weight: 400;
                text-align: center;
            }

            .mobile-filter-reset,
            .mobile-filter-close {
                border: 0;
                background: transparent;
                color: #111;
                padding: 0;
            }

            .mobile-filter-reset {
                font-size: 12px;
                text-align: left;
            }

            .mobile-filter-close {
                font-size: 34px;
                line-height: 1;
                text-align: right;
            }

            .desktop-filter-title {
                display: none;
            }

            .filter-group {
                margin-bottom: 26px;
                padding-bottom: 18px;
                border-bottom: 1px solid #d8d8d8;
            }

            .filter-group-title {
                margin-bottom: 16px;
                font-size: 16px;
                font-weight: 500;
                color: #111;
                text-transform: uppercase;
            }

            .filter-option {
                display: flex;
                align-items: center;
                gap: 9px;
                margin-bottom: 10px;
                font-size: 14px;
                color: #111;
            }

            .filter-option input {
                width: 14px;
                height: 14px;
                accent-color: #2f6fc7;
            }

            .mobile-apply-filter {
                display: block;
                position: fixed;
                left: 20px;
                right: 20px;
                bottom: 8px;
                height: 40px;
                border: 0;
                border-radius: 999px;
                background: #2f6fc7;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                z-index: 3;
            }

            body.filter-open {
                overflow: hidden;
            }
        }
        .special-offer-badge {
    display: inline-block;
    margin-top: 8px;
    margin-bottom: 14px;
    padding: 6px 9px;
    background: #f1f2f5;
    border-radius: 6px;
    color: #111;
    font-size: 14px;
    line-height: 1.3;
}

.special-offer-badge strong {
    font-weight: 700;
}

.special-offer-badge span {
    color: #333;
    font-size: 13px;
}
    </style>
@endsection
@section('content')

    @if ($banners->count())
        <section class="product-list-banner-wrap">
            <div id="productListBannerCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">
                    @foreach ($banners as $index => $banner)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            @if ($banner->image_path)
                                <picture>
                                    @if ($banner->image_mobile)
                                        <source media="(max-width: 768px)"
                                            srcset="{{ asset('storage/' . $banner->image_mobile) }}">
                                    @endif
                                    <img src="{{ asset('storage/' . $banner->image_path) }}"
                                        class="d-block w-100 product-list-banner-img"
                                        alt="Product list banner {{ $index + 1 }}">
                                </picture>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
    <section class="pl-category-section ">
        <div class="pl-category-inner">
            <h2>Todos os produtos</h2>

            @php
                $displayCategories = $categories;

                if ($categories->count() > 0 && $categories->count() < 8) {
                    $repeatTimes = ceil(8 / $categories->count());
                    $displayCategories = collect();

                    for ($i = 0; $i < $repeatTimes; $i++) {
                        $displayCategories = $displayCategories->concat($categories);
                    }

                    $displayCategories = $displayCategories->take(8);
                }
            @endphp

            <div class="swiper pl-category-swiper">
                <div class="swiper-wrapper">
                    @foreach ($displayCategories as $category)
                        <div class="swiper-slide">
                            <button type="button"
                                class="pl-category-btn {{ in_array((string) $category->category_id, (array) $categoryIds) ? 'active' : '' }}"
                                data-category-id="{{ $category->category_id }}">
                                <span class="pl-category-img">
                                    @if ($category->image_path)
                                        <img src="{{ asset('storage/' . $category->image_path) }}"
                                            alt="{{ $category->category_name }}">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                    @endif
                                </span>

                                <span class="pl-category-name">
                                    {{ $category->category_name }}
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="product-page" id="product-list-section">

        <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>

        <aside class="filter-box" id="mobileFilterPanel">
            <div class="mobile-filter-header">
                <button type="button" class="mobile-filter-reset" id="mobileFilterReset">
                    Reset All
                </button>

                <h3>Filters</h3>

                <button type="button" class="mobile-filter-close" id="mobileFilterClose">
                    ×
                </button>
            </div>

            <div class="filter-title desktop-filter-title">☰ Filtrar Por</div>

            <form action="{{ route('products.index') }}" method="GET" id="product-filter-form">
                <input type="hidden" name="product_type" value="{{ $productType }}" id="product-type-input">

                <div class="filter-group">
                    <div class="filter-group-title">{{ __('product.product_list.categories') }}</div>

                    @foreach ($categories as $category)
                        <label class="filter-option">
                            <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                                {{ in_array((string) $category->category_id, (array) $categoryIds) ? 'checked' : '' }}>
                            <span>{{ $category->category_name }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="filter-group">
                    <div class="filter-group-title">{{ __('product.product_list.accessories') }}</div>

                    @foreach ($materials as $material)
                        <label class="filter-option">
                            <input type="checkbox" name="materials[]" value="{{ $material->material_id }}"
                                {{ in_array((string) $material->material_id, (array) $materialIds) ? 'checked' : '' }}>
                            <span>{{ $material->material_name }}</span>
                        </label>
                    @endforeach
                </div>

                <button type="button" class="mobile-apply-filter" id="mobileApplyFilter">
                    Apply filters
                </button>
            </form>
        </aside>

        <main>
            <div class="content-header">
                <h1 class="d-none d-lg-block">{{ __('product.product_list.category_persona') }}</h1>
                <p class="d-none d-lg-block">{{ __('product.product_list.switcher') }}</p>

                <div class="type-tabs">
                    <a href="{{ route('products.index', ['product_type' => 2]) }}" data-product-type="2"
                        class="type-card product-type-link {{ (int) $productType === 2 ? 'active' : '' }}">
                        <img src="{{ asset('assets/images/icon/image-Photoroom (55) 1.png') }}" alt="">
                        <div class="label">{{ __('product.product_list.brindes') }}<br>{{ __('product.product_list.personalizados') }}</div>
                    </a>

                    <a href="{{ route('products.index', ['product_type' => 1]) }}" data-product-type="1"
                        class="type-card product-type-link {{ (int) $productType === 1 ? 'active' : '' }}">
                        <img src="{{ asset('assets/images/icon/image-Photoroom (55) 2.png') }}" alt="">
                        <div class="label">{{ __('product.product_list.cordao') }}<br>{{ __('product.product_list.personalizados') }}</div>
                    </a>
                </div>
            </div>
            <div class="mobile-filter-bar">
                <button type="button" class="mobile-filter-open" id="mobileFilterOpen">
                    <i class="bi bi-sliders"></i>
                    Filtrar Por
                </button>

                {{-- <span class="mobile-product-count">
            Showing {{ $products->total() }} Products
        </span> --}}
            </div>

            <div class="products-grid" id="products-grid">
                @include('products.partials.product_cards', ['products' => $products])
            </div>

            <div class="pagination-wrap" id="products-pagination">
                {{ $products->links() }}
            </div>
        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('product-filter-form');
            const productsGrid = document.getElementById('products-grid');
            const productsPagination = document.getElementById('products-pagination');
            const productTypeInput = document.getElementById('product-type-input');

            if (typeof Swiper !== 'undefined') {
                new Swiper('.pl-category-swiper', {
                    slidesPerView: 8,
                    slidesPerGroup: 1,
                    spaceBetween: 22,
                    loop: true,
                    navigation: {
                        nextEl: '.pl-category-swiper-next',
                        prevEl: '.pl-category-swiper-prev',
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 3,
                            spaceBetween: 12,
                        },
                        576: {
                            slidesPerView: 4,
                            spaceBetween: 14,
                        },
                        768: {
                            slidesPerView: 5,
                            spaceBetween: 18,
                        },
                        992: {
                            slidesPerView: 8,
                            spaceBetween: 22,
                        }
                    }
                });
            }

            function updateCategorySlideActive() {
                const checkedCategoryIds = Array.from(
                    document.querySelectorAll('.filter-box input[name="categories[]"]:checked')
                ).map(function(input) {
                    return input.value;
                });

                document.querySelectorAll('.pl-category-btn').forEach(function(button) {
                    if (checkedCategoryIds.includes(button.dataset.categoryId)) {
                        button.classList.add('active');
                    } else {
                        button.classList.remove('active');
                    }
                });
            }

            function getFilterParams() {
                const formData = new FormData(filterForm);
                return new URLSearchParams(formData);
            }

            function loadProducts(url = null) {
                let browserUrl;
                let ajaxUrl;

                if (url) {
                    const urlObj = new URL(url, window.location.origin);

                    urlObj.searchParams.set('_ajax', '1');
                    ajaxUrl = urlObj.toString();

                    urlObj.searchParams.delete('_ajax');
                    browserUrl = urlObj.pathname + '?' + urlObj.searchParams.toString();
                } else {
                    const params = getFilterParams();

                    const ajaxParams = new URLSearchParams(params);
                    ajaxParams.set('_ajax', '1');

                    ajaxUrl = `${filterForm.action}?${ajaxParams.toString()}`;
                    browserUrl = `${filterForm.action}?${params.toString()}`;
                }

                fetch(ajaxUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('HTTP ' + response.status);
                        }

                        return response.json();
                    })
                    .then(function(data) {
                        productsGrid.innerHTML = data.html;
                        productsPagination.innerHTML = data.pagination;

                        const cleanUrl = browserUrl.replace(window.location.origin, '');

                        window.history.replaceState({}, '', cleanUrl);

                        updateCategorySlideActive();
                    })
                    .catch(function(error) {
                        console.error('Filter error:', error);
                    });
            }

            document.querySelectorAll('.filter-box input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateCategorySlideActive();
                    loadProducts();
                });
            });

            document.querySelectorAll('.pl-category-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const categoryId = this.dataset.categoryId;

                    const checkbox = document.querySelector(
                        '.filter-box input[name="categories[]"][value="' + categoryId + '"]'
                    );

                    if (!checkbox) {
                        console.warn('Category checkbox not found:', categoryId);
                        return;
                    }

                    checkbox.checked = !checkbox.checked;

                    updateCategorySlideActive();
                    loadProducts();
                });
            });

            document.querySelectorAll('.product-type-link').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const selectedType = this.dataset.productType;
                    productTypeInput.value = selectedType;

                    document.querySelectorAll('.product-type-link').forEach(function(item) {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');

                    loadProducts();
                });
            });

            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('#products-pagination a');

                if (paginationLink) {
                    e.preventDefault();
                    loadProducts(paginationLink.href);
                }
            });

            updateCategorySlideActive();
        });
    </script>
    <script>
        const mobileFilterOpen = document.getElementById('mobileFilterOpen');
        const mobileFilterClose = document.getElementById('mobileFilterClose');
        const mobileFilterPanel = document.getElementById('mobileFilterPanel');
        const mobileFilterOverlay = document.getElementById('mobileFilterOverlay');
        const mobileApplyFilter = document.getElementById('mobileApplyFilter');
        const mobileFilterReset = document.getElementById('mobileFilterReset');

        function openMobileFilter() {
            mobileFilterPanel.classList.add('is-open');
            mobileFilterOverlay.classList.add('is-open');
            document.body.classList.add('filter-open');
        }

        function closeMobileFilter() {
            mobileFilterPanel.classList.remove('is-open');
            mobileFilterOverlay.classList.remove('is-open');
            document.body.classList.remove('filter-open');
        }

        if (mobileFilterOpen) {
            mobileFilterOpen.addEventListener('click', openMobileFilter);
        }

        if (mobileFilterClose) {
            mobileFilterClose.addEventListener('click', closeMobileFilter);
        }

        if (mobileFilterOverlay) {
            mobileFilterOverlay.addEventListener('click', closeMobileFilter);
        }

        if (mobileApplyFilter) {
            mobileApplyFilter.addEventListener('click', function() {
                closeMobileFilter();

                setTimeout(function() {
                    document.getElementById('product-list-section')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 350);
            });
        }

        if (mobileFilterReset) {
            mobileFilterReset.addEventListener('click', function() {
                document.querySelectorAll('#product-filter-form input[type="checkbox"]').forEach(function(input) {
                    input.checked = false;
                });

                updateCategorySlideActive();
            });
        }
    </script>
@endsection
