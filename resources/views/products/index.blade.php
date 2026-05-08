@extends('layouts.app')

@section('title', 'Products')

@section('content')

@if($banners->count())
    <section class="product-list-banner-wrap">
        <div id="productListBannerCarousel" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        @if($banner->image_path)
                            <img 
                                src="{{ asset('storage/' . $banner->image_path) }}" 
                                class="d-block w-100 product-list-banner-img"
                                alt="Product list banner {{ $index + 1 }}"
                            >
                        @endif
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif
<section class="category-swiper-section">
    <div class="category-swiper-inner">
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

        <div class="swiper category-swiper">
            <div class="swiper-wrapper">
                @foreach($displayCategories as $category)
                    <div class="swiper-slide">
                        <button 
                            type="button"
                            class="category-slide-btn {{ in_array((string) $category->category_id, (array) $categoryIds) ? 'active' : '' }}"
                            data-category-id="{{ $category->category_id }}"
                        >
                            <span class="category-slide-img">
                                @if($category->image_path)
                                    <img 
                                        src="{{ asset('storage/' . $category->image_path) }}" 
                                        alt="{{ $category->category_name }}"
                                    >
                                @else
                                    <img 
                                        src="{{ asset('images/no-image.png') }}" 
                                        alt="No image"
                                    >
                                @endif
                            </span>

                            <span class="category-slide-name">
                                {{ $category->category_name }}
                            </span>
                        </button>
                    </div>
                @endforeach
            </div>

            {{-- <div class="category-swiper-prev swiper-button-prev"></div>
            <div class="category-swiper-next swiper-button-next"></div> --}}
        </div>
    </div>
</section>

<div class="product-page" id="product-list-section">

    <aside class="filter-box">
        <div class="filter-title">☰ Filtrar Por</div>

        <form action="{{ route('products.index') }}" method="GET" id="product-filter-form">
            <input type="hidden" name="product_type" value="{{ $productType }}" id="product-type-input">

            <div class="filter-group">
                <div class="filter-group-title">Por Categorias</div>

                @foreach($categories as $category)
                    <label class="filter-option">
                        <input 
    type="checkbox" 
    name="categories[]" 
    value="{{ $category->category_id }}"
    {{ in_array((string) $category->category_id, (array) $categoryIds) ? 'checked' : '' }}
>
                        <span>{{ $category->category_name }}</span>
                    </label>
                @endforeach
            </div>

            <div class="filter-group">
                <div class="filter-group-title">Por Material</div>

                @foreach($materials as $material)
                    <label class="filter-option">
                        <input 
                            type="checkbox" 
                            name="materials[]" 
                            value="{{ $material->material_id }}"
                            {{ in_array((string) $material->material_id, (array) $materialIds) ? 'checked' : '' }}
                        >
                        <span>{{ $material->material_name }}</span>
                    </label>
                @endforeach
            </div>
        </form>
    </aside>

    <main>
        <div class="content-header">
            <h1>Shop by Category/Persona</h1>
            <p>Tap Switcher</p>

            <div class="type-tabs">
                <a 
                    href="{{ route('products.index', ['product_type' => 2]) }}" 
                    data-product-type="2"
                    class="type-card product-type-link {{ (int) $productType === 2 ? 'active' : '' }}"
                >
                    <img src="{{ asset('assets/images/icon/image-Photoroom (55) 1.png') }}" alt="">
                    <div class="label">Brindes<br>Personalizados</div>
                </a>

                <a 
                    href="{{ route('products.index', ['product_type' => 1]) }}" 
                    data-product-type="1"
                    class="type-card product-type-link {{ (int) $productType === 1 ? 'active' : '' }}"
                >
                    <img src="{{ asset('assets/images/icon/image-Photoroom (55) 2.png') }}" alt="">
                    <div class="label">Cordão<br>Personalizado</div>
                </a>
            </div>
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
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('product-filter-form');
    const productsGrid = document.getElementById('products-grid');
    const productsPagination = document.getElementById('products-pagination');
    const productTypeInput = document.getElementById('product-type-input');

    if (typeof Swiper !== 'undefined') {
        new Swiper('.category-swiper', {
            slidesPerView: 8,
            slidesPerGroup: 1,
            spaceBetween: 22,
            loop: true,
            navigation: {
                nextEl: '.category-swiper-next',
                prevEl: '.category-swiper-prev',
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
        ).map(function (input) {
            return input.value;
        });

        document.querySelectorAll('.category-slide-btn').forEach(function (button) {
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
        .then(function (response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            return response.json();
        })
        .then(function (data) {
            productsGrid.innerHTML = data.html;
            productsPagination.innerHTML = data.pagination;

            const cleanUrl = browserUrl.replace(window.location.origin, '');

            window.history.replaceState({}, '', cleanUrl);

            updateCategorySlideActive();
        })
        .catch(function (error) {
            console.error('Filter error:', error);
        });
    }

    document.querySelectorAll('.filter-box input[type="checkbox"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            updateCategorySlideActive();
            loadProducts();
        });
    });

    document.querySelectorAll('.category-slide-btn').forEach(function (button) {
        button.addEventListener('click', function () {
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

    document.querySelectorAll('.product-type-link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const selectedType = this.dataset.productType;
            productTypeInput.value = selectedType;

            document.querySelectorAll('.product-type-link').forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');

            loadProducts();
        });
    });

    document.addEventListener('click', function (e) {
        const paginationLink = e.target.closest('#products-pagination a');

        if (paginationLink) {
            e.preventDefault();
            loadProducts(paginationLink.href);
        }
    });

    updateCategorySlideActive();
});
</script>
@endsection