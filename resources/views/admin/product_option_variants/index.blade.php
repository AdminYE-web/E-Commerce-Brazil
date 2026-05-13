@extends('admin.layouts.app')

@section('title', 'Option Variants | Indigo Admin')

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

    .variant-img {
        width: 58px;
        height: 58px;
        border-radius: 8px;
        border: 1px solid var(--border);
        object-fit: contain;
        background: var(--bg);
        padding: 4px;
    }

    .color-dot-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .color-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid var(--border);
        display: inline-block;
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
</style>
@endsection

@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Option Variants</div>
            <div class="showing-text">
                Option: <strong>{{ $option->option_name }}</strong>
                |
                Group: {{ $option->group->group_name ?? '-' }}
            </div>
        </div>

        <div class="table-actions">
            <a href="{{ route('admin.product-options.index') }}" class="btn-outline">
                Back
            </a>

            <a href="{{ route('admin.product-options.variants.create', $option->option_id) }}" class="btn-primary">
                + Add Variant
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Variant</th>
                <th>Color</th>
                <th>Additional Price</th>
                <th>Sort</th>
                <th>Default</th>
                <th>Status</th>
                <th style="text-align: right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse($option->variants as $variant)
                <tr>
                    <td>
                        <div class="product-cell">
                            @if($variant->image_path)
                                <img
                                    src="{{ asset('storage/' . $variant->image_path) }}"
                                    class="variant-img"
                                    alt="{{ $variant->variant_name }}"
                                >
                            @else
                                <div class="variant-img"></div>
                            @endif

                            <div class="product-details">
                                <span class="product-name">
                                    {{ $variant->variant_name }}
                                </span>
                                <span class="product-sku">
                                    ID: {{ $variant->variant_id }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if($variant->color_code)
                            <span class="color-dot-wrap">
                                <span class="color-dot" style="background: {{ $variant->color_code }}"></span>
                                {{ $variant->color_code }}
                            </span>
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ number_format($variant->additional_price, 2) }}</td>

                    <td>{{ $variant->sort_order }}</td>

                    <td>{{ $variant->is_default ? 'Yes' : 'No' }}</td>

                    <td>
                        @if($variant->is_active)
                            <span class="status-pill status-active">Active</span>
                        @else
                            <span class="status-pill status-inactive">Inactive</span>
                        @endif
                    </td>

                    <td style="text-align: right;">
                        <div class="action-btns" style="justify-content: flex-end;">
                            <a href="{{ route('admin.product-option-variants.edit', $variant->variant_id) }}"
                               class="action-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.product-option-variants.destroy', $variant->variant_id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-link delete"
                                        onclick="return confirm('Delete this variant?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 32px;">
                        No variants found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection