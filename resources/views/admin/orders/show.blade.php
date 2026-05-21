@extends('admin.layouts.app')

@section('title', 'Order Detail | Indigo Admin')

@section('css')
<style>
    .order-detail-card {
        max-width: 1280px;
        margin: 0 auto;
        padding: 24px;
    }

    .alert-success {
        margin-bottom: 18px;
        padding: 12px 16px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        font-size: 14px;
    }

    .section-title {
        margin: 34px 0 16px;
        padding-top: 22px;
        border-top: 1px solid var(--border);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg-dark);
    }

    .status-box {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
    }

    .status-form {
        max-width: 760px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--fg-dark);
    }

    .form-group select {
        width: 100%;
        height: 40px;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0 12px;
        background: #fff;
        font-family: inherit;
        font-size: 14px;
    }

    .btn-primary,
    .btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        font-family: inherit;
    }

    .btn-primary {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
        margin-top: 16px;
    }

    .btn-outline {
        background: #fff;
        border-color: var(--border);
        color: var(--fg);
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .info-table th,
    .info-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border);
        text-align: left;
        vertical-align: top;
        font-size: 14px;
    }

    .info-table th {
        width: 220px;
        background: var(--bg);
        color: var(--fg-dark);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        font-size: 12px;
    }

    .info-table td {
        background: #fff;
    }

    .info-table tr:last-child th,
    .info-table tr:last-child td {
        border-bottom: 0;
    }

    table {
        margin-top: 8px;
    }

    table thead th {
        background: var(--bg);
        color: var(--muted);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .product-img {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        border: 1px solid var(--border);
        object-fit: cover;
        background: var(--bg);
    }

    .product-name {
        font-weight: 700;
        color: var(--fg-dark);
    }

    .option-box {
        margin-bottom: 8px;
        padding: 8px 10px;
        background: var(--bg);
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.5;
    }

    .amount-text,
    .summary-total {
        font-weight: 700;
        color: var(--fg-dark);
        white-space: nowrap;
    }

    .summary-total {
        font-size: 18px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: 12px;
        font-weight: 600;
        color: var(--fg);
        text-transform: capitalize;
    }

    .file-link {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .file-link:hover {
        text-decoration: underline;
    }

    .document-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    @media (max-width: 900px) {
        .order-detail-card {
            padding: 18px;
        }

        .status-form {
            grid-template-columns: 1fr;
        }

        .table-card {
            overflow-x: auto;
        }

        table {
            min-width: 1000px;
        }

        .info-table {
            min-width: 0;
        }

        .document-actions {
            justify-content: flex-start;
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="table-card order-detail-card">

    <div class="table-header">
        <div>
            <div class="table-title">Order Detail</div>
            <div class="showing-text">
                Order No:
                <strong>{{ $order->order_no }}</strong>
            </div>
        </div>

        <div class="document-actions">
            <a href="{{ route('admin.orders.quotation', $order->order_id) }}" class="btn-outline">
                Download Quotation
            </a>

            <a href="{{ route('admin.orders.invoice', $order->order_id) }}" class="btn-outline">
                Download Invoice
            </a>

            <a href="{{ route('admin.orders.index') }}" class="btn-outline">
                Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="section-title">Order Status</div>

    <form action="{{ route('admin.orders.updateStatus', $order->order_id) }}" method="POST" class="status-box">
        @csrf
        @method('PUT')

        <div class="status-form">
            <div class="form-group">
                <label>Order Status</label>

               <select name="status">
    @foreach(['order_pending','design_in_progress','production','delivery','delivered','completed','cancelled'] as $status)
        <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
            {{ ucwords(str_replace('_', ' ', $status)) }}
        </option>
    @endforeach
</select>
            </div>

            <div class="form-group">
                <label>Payment Status</label>

               <select name="payment_status">
    @foreach(['pending','paid','failed','cancelled','refunded'] as $paymentStatus)
        <option value="{{ $paymentStatus }}"
            {{ $order->payment_status == $paymentStatus ? 'selected' : '' }}>
            {{ ucfirst($paymentStatus) }}
        </option>
    @endforeach
</select>
            </div>
        </div>

        <button type="submit" class="btn-primary">
            Update Status
        </button>
    </form>

    <div class="section-title">Customer Information</div>

    <table class="info-table">
        <tr>
            <th>Name</th>
            <td>
                {{ $order->customer->personal_first_name ?? '-' }}
                {{ $order->customer->personal_last_name ?? '' }}
            </td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $order->customer->personal_email ?? '-' }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $order->customer->personal_phone ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Shipping Address</div>

    <table class="info-table">
        <tr>
            <th>Postcode</th>
            <td>{{ $order->customer->shipping_postcode ?? '-' }}</td>
        </tr>
        <tr>
            <th>Province</th>
            <td>{{ $order->customer->shipping_province ?? '-' }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{{ $order->customer->shipping_city ?? '-' }}</td>
        </tr>
        <tr>
            <th>Area</th>
            <td>{{ $order->customer->shipping_area ?? '-' }}</td>
        </tr>
        <tr>
            <th>Building / Room</th>
            <td>{{ $order->customer->shipping_building_room ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Order Items</div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Options</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        @if($item->product_image)
                            <img src="{{ asset('storage/' . $item->product_image) }}" class="product-img">
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <div class="product-name">
                            {{ $item->product_name_snapshot ?? $item->product_name }}
                        </div>
                    </td>

                    <td>{{ $item->qty ?? $item->quantity }}</td>

                    <td>¥ {{ number_format($item->unit_price, 2) }}</td>

                    <td>
                        @php
                            $options = is_array($item->options)
                                ? $item->options
                                : json_decode($item->options ?? '[]', true);
                        @endphp

                        @if(!empty($options))
                            @foreach($options as $option)
                                <div class="option-box">
                                    <strong>{{ $option['group_name'] ?? '-' }}:</strong>
                                    {{ $option['option_name'] ?? '-' }}

                                    @if(!empty($option['variant_name']))
                                        - {{ $option['variant_name'] }}
                                    @endif
                                </div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <span class="amount-text">
                            ¥ {{ number_format($item->item_total, 2) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Artwork / Template Information</div>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>File</th>
                <th>No Artwork</th>
                <th>Text</th>
                <th>Font</th>
                <th>Template ID</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($order->artworks as $artwork)
                <tr>
                    <td>{{ $artwork->product_id }}</td>

                    <td>
                        @if($artwork->file_path)
                            <a href="{{ asset('storage/' . $artwork->file_path) }}" target="_blank" class="file-link">
                                {{ $artwork->original_name ?? 'View file' }}
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $artwork->no_artwork ? 'Yes' : 'No' }}</td>

                    <td>{{ $artwork->print_text ?? '-' }}</td>

                    <td>
                        {{ $artwork->font_option ?? '-' }}
                        @if($artwork->font_other)
                            / {{ $artwork->font_other }}
                        @endif
                    </td>

                    <td>{{ $artwork->template_id ?? '-' }}</td>

                    <td>
                        <span class="status-pill">
                            {{ ucfirst($artwork->status ?? 'pending') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:32px;">
                        No artwork data.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Payment</div>

    <table class="info-table">
        <tr>
            <th>Method</th>
            <td>{{ $order->payment->payment_method ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="status-pill">
                    {{ $order->payment_status ?? '-' }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Transaction ID</th>
            <td>{{ $order->payment->transaction_id ?? '-' }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>¥ {{ number_format($order->payment->amount ?? 0, 2) }}</td>
        </tr>
    </table>

    <div class="section-title">Summary</div>

    <table class="info-table">
        <tr>
            <th>Subtotal</th>
            <td>¥ {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <th>Shipping</th>
            <td>¥ {{ number_format($order->shipping_fee, 2) }}</td>
        </tr>
        <tr>
            <th>VAT</th>
            <td>¥ {{ number_format($order->vat_amount, 2) }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td>
                <span class="summary-total">
                    ¥ {{ number_format($order->grand_total, 2) }}
                </span>
            </td>
        </tr>
    </table>

</div>

@endsection
