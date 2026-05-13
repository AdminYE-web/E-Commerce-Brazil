@extends('admin.layouts.app')

@section('title', 'Product Price Rule Detail | Indigo Admin')

@section('css')
<style>
    .detail-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }

    .detail-header h1 {
        margin: 0 0 6px;
        font-size: 24px;
        color: var(--fg-dark);
    }

    .detail-header p {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .info-box {
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--bg);
        padding: 14px 16px;
    }

    .info-label {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 700;
        color: var(--fg-dark);
    }

    .section-title {
        margin: 28px 0 14px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg-dark);
    }

    .option-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .option-pill {
        border: 1px solid var(--border);
        background: #fff;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        color: var(--fg);
    }

    .price-table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: #fff;
    }

    .price-table th,
    .price-table td {
        border-bottom: 1px solid var(--border);
        padding: 13px 14px;
        text-align: left;
        font-size: 14px;
    }

    .price-table th {
        background: var(--bg);
        color: var(--fg-dark);
        font-weight: 700;
    }

    .price-table tr:last-child td {
        border-bottom: 0;
    }

    .price-table .price {
        font-weight: 800;
        color: var(--accent);
    }

    .status-active {
        color: #15803d;
        font-weight: 700;
    }

    .status-inactive {
        color: #b91c1c;
        font-weight: 700;
    }

    .detail-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }

    .btn-outline,
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-outline {
        background: #fff;
        border: 1px solid var(--border);
        color: var(--fg);
    }

    .btn-primary {
        background: var(--accent);
        border: 1px solid var(--accent);
        color: #fff;
    }

    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')

<div class="detail-card">
    <div class="detail-header">
        <div>
            <h1>Product Price Rule Detail</h1>
            <p>View selected options and quantity price tiers.</p>
        </div>

        <a href="{{ route('admin.product-price-rules.index') }}" class="btn-outline">
            Back
        </a>
    </div>

    <div class="detail-grid">
        <div class="info-box">
            <div class="info-label">Product</div>
            <div class="info-value">
                {{ $rule->product->product_name ?? '-' }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">Rule Name</div>
            <div class="info-value">
                {{ $rule->rule_name ?? '-' }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">Status</div>
            <div class="info-value">
                @if($rule->is_active)
                    <span class="status-active">Active</span>
                @else
                    <span class="status-inactive">Inactive</span>
                @endif
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">Sort Order</div>
            <div class="info-value">
                {{ $rule->sort_order ?? 0 }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">Created At</div>
            <div class="info-value">
                {{ $rule->created_at ? $rule->created_at->format('d/m/Y H:i') : '-' }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">Updated At</div>
            <div class="info-value">
                {{ $rule->updated_at ? $rule->updated_at->format('d/m/Y H:i') : '-' }}
            </div>
        </div>
    </div>

    <div class="section-title">Required Options</div>

    @if($rule->options && $rule->options->count())
        <div class="option-list">
            @foreach($rule->options as $option)
                <div class="option-pill">
                    {{ $option->group->group_name ?? 'Option Group' }}
                    :
                    <strong>{{ $option->option_name }}</strong>
                </div>
            @endforeach
        </div>
    @else
        <p>No selected options.</p>
    @endif

    <div class="section-title">Quantity Price Tiers</div>

    <table class="price-table">
        <thead>
            <tr>
                <th style="width:80px;">#</th>
                <th>Min Qty</th>
                <th>Max Qty</th>
                <th>Unit Price</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rule->tiers as $index => $tier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($tier->min_qty) }}</td>
                    <td>
                        @if($tier->max_qty)
                            {{ number_format($tier->max_qty) }}
                        @else
                            No limit
                        @endif
                    </td>
                    <td class="price">
                        ¥ {{ number_format($tier->unit_price, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No price tiers.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="detail-actions">
        <a href="{{ route('admin.product-price-rules.index') }}" class="btn-outline">
            Back
        </a>

        <a href="{{ route('admin.product-price-rules.edit', $rule->rule_id) }}" class="btn-primary">
            Edit Price Rule
        </a>
    </div>
</div>

@endsection