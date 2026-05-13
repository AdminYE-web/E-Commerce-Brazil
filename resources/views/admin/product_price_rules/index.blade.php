@extends('admin.layouts.app')

@section('title', 'Product Price Rules | Indigo Admin')
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
        margin: 2px 4px 2px 0;
        padding: 5px 9px;
        border-radius: 999px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: 12px;
        color: var(--fg);
        white-space: nowrap;
    }

    .tier-line {
        font-size: 13px;
        line-height: 1.6;
        color: var(--fg);
        white-space: nowrap;
    }

    .muted-text {
        color: var(--muted);
        font-size: 13px;
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

        .table-actions {
            width: 100%;
            flex-wrap: wrap;
        }
    }
</style>
@endsection
@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Product Price Rules</div>
            <div class="showing-text">
                Manage pricing rules by product, required options and quantity tiers.
            </div>
        </div>

        <div class="table-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                Dashboard
            </a>

            <a href="{{ route('admin.product-price-rules.create') }}" class="btn-primary">
                + Add Price Rule
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
                <th>Rule</th>
                <th>Product</th>
                <th>Required Options</th>
              
                <th>Status</th>
                <th style="text-align: right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($rules as $rule)
                <tr>
                    <td>
                        <div class="product-details">
                            <span class="product-name">
                                {{ $rule->rule_name ?? '-' }}
                            </span>
                            <span class="product-sku">
                                ID: {{ $rule->rule_id }}
                            </span>
                        </div>
                    </td>

                    <td>
                        {{ $rule->product->product_name ?? '-' }}
                    </td>

                    <td>
                        @forelse ($rule->options as $option)
                            <div class="mini-badge">
                                {{ $option->group->group_name ?? '-' }}
                                /
                                <strong>{{ $option->option_name }}</strong>
                            </div>
                        @empty
                            <span class="muted-text">No options</span>
                        @endforelse
                    </td>

                    

                    <td>
                        @if ($rule->is_active)
                            <span class="status-pill status-active">Active</span>
                        @else
                            <span class="status-pill status-inactive">Inactive</span>
                        @endif
                    </td>

                    <td style="text-align: right;">
                        <div class="action-btns" style="justify-content: flex-end;">
                            <a href="{{ route('admin.product-price-rules.show', $rule->rule_id) }}"
                               class="action-link">
                                Detail
                            </a>
                            <a href="{{ route('admin.product-price-rules.edit', $rule->rule_id) }}"
                               class="action-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.product-price-rules.destroy', $rule->rule_id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-link delete"
                                        onclick="return confirm('Delete this rule?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 32px;">
                        No price rules found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $rules->links() }}
    </div>
</div>

@endsection