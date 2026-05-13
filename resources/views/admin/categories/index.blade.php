@extends('admin.layouts.app')

@section('title', 'Categories | Indigo Admin')

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

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 9px 18px;
        border-radius: 8px;
        background: var(--accent);
        border: 1px solid var(--accent);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
        line-height: 1;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
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

    .category-img {
        width: 58px;
        height: 58px;
        border-radius: 8px;
        border: 1px solid var(--border);
        object-fit: contain;
        background: var(--bg);
        padding: 4px;
    }

    .sort-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 28px;
        border-radius: 999px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: 12px;
        font-weight: 600;
        color: var(--fg);
    }

    @media (max-width: 900px) {
        .table-card {
            overflow-x: auto;
        }

        table {
            min-width: 900px;
        }

        .table-header {
            align-items: flex-start;
            gap: 14px;
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Categories</div>
            <div class="showing-text">
                Manage product categories, images, sort order and status.
            </div>
        </div>

        <div class="table-actions">
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                + Add Category
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
                <th>Category</th>
                <th>Code</th>
                <th>Sort</th>
                <th>Status</th>
                <th style="text-align: right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>
                        <div class="product-cell">
                            @if ($category->image_path)
                                <img
                                    src="{{ asset('storage/' . $category->image_path) }}"
                                    class="category-img"
                                    alt="{{ $category->category_name }}"
                                >
                            @else
                                <div class="category-img"></div>
                            @endif

                            <div class="product-details">
                                <span class="product-name">
                                    {{ $category->category_name }}
                                </span>
                                <span class="product-sku">
                                    ID: {{ $category->category_id }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <td>{{ $category->category_code }}</td>

                    <td>
                        <span class="sort-badge">
                            {{ $category->sort_order }}
                        </span>
                    </td>

                    <td>
                        @if ($category->is_active)
                            <span class="status-pill status-active">Active</span>
                        @else
                            <span class="status-pill status-inactive">Inactive</span>
                        @endif
                    </td>

                    <td style="text-align: right;">
                        <div class="action-btns" style="justify-content: flex-end;">
                            <a href="{{ route('admin.categories.edit', $category->category_id) }}"
                               class="action-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category->category_id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-link delete"
                                        onclick="return confirm('Delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 32px;">
                        No categories found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $categories->links() }}
    </div>
</div>

@endsection