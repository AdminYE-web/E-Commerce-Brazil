@extends('admin.layouts.app')

@section('title', 'Products | Indigo Admin')

@section('css')
<style>
.alert-success {
    margin: 0 24px 16px;
    padding: 12px 16px;
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
    border-radius: 8px;
    font-size: 14px;
}

.action-link {
    border: none;
    background: none;
    color: var(--accent);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    padding: 0;
    font-family: inherit;
}

.action-link:hover {
    text-decoration: underline;
}

.action-link.delete {
    color: #dc2626;
}
</style>
@endsection
@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Products</div>
            <div class="showing-text">Manage product data, options, details, images and status.</div>
        </div>

        <div class="table-actions">
            <a href="{{ route('admin.products.create') }}" class="btn-outline">
                + Add Product
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Type</th>
                <th>Category</th>
                <th>Material</th>
                <th>Antivirus</th>
                <th>Status</th>
                <th style="text-align: right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        <div class="product-cell">
                            @if ($product->mainImage)
                                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                                     class="product-img"
                                     alt="{{ $product->product_name }}">
                            @else
                                <div class="product-img"></div>
                            @endif

                            <div class="product-details">
                                <span class="product-name">{{ $product->product_name }}</span>
                                <span class="product-sku">
                                    ID: {{ $product->product_id }} | Code: {{ $product->product_code }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if ($product->product_type == 1)
                            hotstrap
                        @elseif ($product->product_type == 2)
                            hotmobily
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <span class="category-text">
                            {{ $product->category->category_name ?? '-' }}
                        </span>
                    </td>

                    <td>
                        {{ $product->material->material_name ?? '-' }}
                    </td>

                    <td>
                        {{ $product->is_antivirus_included ? 'Yes' : 'No' }}
                    </td>

                    <td>
                        @if ($product->is_active)
                            <span class="status-pill status-active">Active</span>
                        @else
                            <span class="status-pill status-inactive">Inactive</span>
                        @endif
                    </td>

                    <td style="text-align: right;">
                        <div class="action-btns" style="justify-content: flex-end;">
                            <a href="{{ route('admin.products.edit', $product->product_id) }}"
                               class="action-link">
                                Edit
                            </a>

                            <a href="{{ route('admin.products.options.edit', $product->product_id) }}"
                               class="action-link">
                                Options
                            </a>

                            @if ($product->detail)
                                <a href="{{ route('admin.product-details.edit', $product->detail->product_detail_id) }}"
                                   class="action-link">
                                    Detail
                                </a>
                            @else
                                <a href="{{ route('admin.product-details.create', ['product_id' => $product->product_id]) }}"
                                   class="action-link">
                                    Add Detail
                                </a>
                            @endif

                            <form action="{{ route('admin.products.destroy', $product->product_id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-link delete"
                                        onclick="return confirm('Delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 32px;">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $products->links() }}
    </div>
</div>

@endsection