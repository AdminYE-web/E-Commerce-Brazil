@extends('layouts.app')

@section('title', 'Search')

@section('css')
<style>
    .search-result-page {
        background: #fff;
        padding: 34px 16px 70px;
    }

    .search-result-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .search-header {
        margin-bottom: 28px;
    }

    .search-breadcrumb {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .search-title {
        margin: 0;
        color: #111;
        font-size: 34px;
        font-weight: 800;
    }

    .search-subtitle {
        margin-top: 8px;
        color: #6b7280;
        font-size: 14px;
    }

    .search-page-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 36px;
        align-items: start;
    }

    .search-filter-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        position: sticky;
        top: 110px;
    }

    .search-filter-title {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        margin-bottom: 18px;
    }

    .filter-group {
        margin-bottom: 24px;
    }

    .filter-group-title {
        margin-bottom: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #0b2d68;
        text-transform: uppercase;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 9px;
        font-size: 14px;
        color: #111;
    }

    .filter-option input {
        width: 14px;
        height: 14px;
        accent-color: #2f6fc7;
    }

    .search-main-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .search-count {
        color: #555;
        font-size: 14px;
    }

    .search-keyword-form {
        display: flex;
        gap: 10px;
    }

    .search-keyword-input {
        width: 280px;
        height: 40px;
        border: 1px solid #d1d5db;
        border-radius: 999px;
        padding: 0 14px;
        outline: none;
        font-size: 14px;
    }

    .search-keyword-btn {
        height: 40px;
        border: 0;
        border-radius: 999px;
        background: #2f6fc7;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        padding: 0 20px;
        cursor: pointer;
    }

    .pagination-wrap {
        margin-top: 34px;
        display: flex;
        justify-content: center;
    }

    .search-empty {
        padding: 48px 20px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #f8fafc;
        color: #777;
        text-align: center;
    }

    @media (max-width: 900px) {
        .search-page-layout {
            grid-template-columns: 1fr;
        }

        .search-filter-box {
            position: static;
        }

        .search-main-top {
            flex-direction: column;
            align-items: stretch;
        }

        .search-keyword-form {
            width: 100%;
        }

        .search-keyword-input {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<section class="search-result-page">
    <div class="search-result-container">

        <div class="search-header">
            <div class="search-breadcrumb">
                ⌂ / Search
            </div>

            <h1 class="search-title">Search Results</h1>

            <div class="search-subtitle">
                @if($keyword)
                    Result for: <strong>{{ $keyword }}</strong>
                @else
                    Please enter a keyword to search products.
                @endif
            </div>
        </div>

        <div class="search-page-layout">

            <aside class="search-filter-box">
                <div class="search-filter-title">☰ Filtrar Por</div>

                <form action="{{ route('search.index') }}" method="GET" id="search-filter-form">
                    <input type="hidden" name="keyword" value="{{ $keyword }}">

                    <div class="filter-group">
                        <div class="filter-group-title">Product Type</div>

                        <label class="filter-option">
                            <input type="radio" name="product_type" value=""
                                {{ empty($productType) ? 'checked' : '' }}>
                            <span>All</span>
                        </label>

                        <label class="filter-option">
                            <input type="radio" name="product_type" value="2"
                                {{ (string)$productType === '2' ? 'checked' : '' }}>
                            <span>Brindes Personalizados</span>
                        </label>

                        <label class="filter-option">
                            <input type="radio" name="product_type" value="1"
                                {{ (string)$productType === '1' ? 'checked' : '' }}>
                            <span>Cordão Personalizado</span>
                        </label>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">{{ __('product.product_list.categories') }}</div>

                        @foreach($categories as $category)
                            <label class="filter-option">
                                <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                                    {{ in_array((string)$category->category_id, (array)$categoryIds) ? 'checked' : '' }}>
                                <span>{{ $category->category_name }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">{{ __('product.product_list.accessories') }}</div>

                        @foreach($materials as $material)
                            <label class="filter-option">
                                <input type="checkbox" name="materials[]" value="{{ $material->material_id }}"
                                    {{ in_array((string)$material->material_id, (array)$materialIds) ? 'checked' : '' }}>
                                <span>{{ $material->material_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </form>
            </aside>

            <main>
                <div class="search-main-top">
                    <div class="search-count">
                        Showing {{ $products->total() }} products
                    </div>

                    <form action="{{ route('search.index') }}" method="GET" class="search-keyword-form">
                        <input 
                            type="text"
                            name="keyword"
                            value="{{ $keyword }}"
                            class="search-keyword-input"
                            placeholder="{{ __('messages.header.search') }}"
                        >

                        <button type="submit" class="search-keyword-btn">
                            Search
                        </button>
                    </form>
                </div>

                @if($products->count())
                    <div class="products-grid" id="products-grid">
                        @include('products.partials.product_cards', ['products' => $products])
                    </div>

                    <div class="pagination-wrap" id="products-pagination">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="search-empty">
                        No products found.
                    </div>
                @endif
            </main>

        </div>
    </div>
</section>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('search-filter-form');

    if (!filterForm) {
        return;
    }

    filterForm.querySelectorAll('input').forEach(function (input) {
        input.addEventListener('change', function () {
            filterForm.submit();
        });
    });
});
</script>
@endsection