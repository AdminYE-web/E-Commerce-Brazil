@extends('admin.layouts.app')

@section('title', 'Product Options | Indigo Admin')

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

        .mini-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 9px;
            border-radius: 999px;
            background: var(--bg);
            border: 1px solid var(--border);
            font-size: 12px;
            color: var(--fg);
            white-space: nowrap;
        }

        @media (max-width: 900px) {
            .table-card {
                overflow-x: auto;
            }

            table {
                min-width: 1000px;
            }

            .table-header {
                align-items: flex-start;
                gap: 14px;
                flex-direction: column;
            }
        }

        .pagination-container {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .page-item {
            list-style: none;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--fg);
            text-decoration: none;
            font-size: 14px;
        }

        .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .page-item.disabled .page-link {
            opacity: .45;
            pointer-events: none;
        }
        .pagination-container nav > div:first-child {
    display: none !important;
}

.pagination-container nav > div:last-child {
    display: block !important;
}

.pagination-container .pagination {
    margin-top: 8px;
}
.product-option-search-form {
    margin: 0 24px 18px;
}

.product-option-search-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.product-option-search-input {
    width: 420px;
    max-width: 100%;
    height: 38px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0 12px;
    font-size: 14px;
    background: #fff;
}

.product-option-search-btn,
.product-option-reset-btn {
    height: 38px;
    border-radius: 8px;
    padding: 0 16px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.product-option-search-btn {
    border: 0;
    background: var(--accent);
    color: #fff;
    cursor: pointer;
}

.product-option-reset-btn {
    border: 1px solid var(--border);
    background: #fff;
    color: var(--fg);
}
    </style>
@endsection

@section('content')

    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="table-title">Product Options</div>
                <div class="showing-text">
                    Manage option choices, prices, variants, images and status.
                </div>
            </div>

            <div class="table-actions">
                <a href="{{ route('admin.product-options.create') }}" class="btn-primary">
                    + Add Product Option
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.product-options.index') }}" class="product-option-search-form">
    <div class="product-option-search-row">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="product-option-search-input"
            placeholder="Search by option name, option code or group..."
        >

        <button type="submit" class="product-option-search-btn">
            Search
        </button>

        @if(request('search'))
            <a href="{{ route('admin.product-options.index') }}" class="product-option-reset-btn">
                Reset
            </a>
        @endif
    </div>
</form>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Group</th>
                    <th>Additional Price</th>
                    <th>Price Type</th>
                    <th>Status</th>
                    <th style="text-align: right;">Manage</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($options as $option)
                    <tr>
                        <td>
                            <div class="product-cell">
                                @if ($option->mainImage)
                                    <img src="{{ asset('storage/' . $option->mainImage->image_path) }}" class="product-img"
                                        alt="{{ $option->option_name }}">
                                @else
                                    <div class="product-img"></div>
                                @endif

                                <div class="product-details">
                                    <span class="product-name">
                                        {{ $option->option_name }}
                                    </span>
                                    <span class="product-sku">
                                        ID: {{ $option->option_id }} | Code: {{ $option->option_code }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $option->group->group_name ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($option->additional_price, 2) }}
                        </td>

                        <td>
                            <span class="mini-badge">
                                {{ $option->price_type }}
                            </span>
                        </td>

                        <td>
                            @if ($option->is_active)
                                <span class="status-pill status-active">Active</span>
                            @else
                                <span class="status-pill status-inactive">Inactive</span>
                            @endif
                        </td>

                        <td style="text-align: right;">
                            <div class="action-btns" style="justify-content: flex-end;">
                                <a href="{{ route('admin.product-options.edit', $option->option_id) }}"
                                    class="action-link">
                                    Edit
                                </a>

                                <a href="{{ route('admin.product-options.variants.index', $option->option_id) }}"
                                    class="action-link">
                                    Variants
                                </a>

                                <form action="{{ route('admin.product-options.destroy', $option->option_id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="action-link delete"
                                        onclick="return confirm('Delete this product option?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 32px;">
                            No product options found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $options->links() }}
        </div>
    </div>

@endsection
