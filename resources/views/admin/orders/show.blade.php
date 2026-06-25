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

        /* ================= ORDER ITEMS TABLE DETAIL ================= */
        .order-items-table-wrap {
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .order-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .order-items-table thead th {
            height: 46px;
            padding: 12px 18px;
            background: #f8fafc;
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .order-items-table tbody td {
            padding: 18px;
            background: #f1f3f6;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 14px;
            color: var(--fg-dark);
        }

        .order-items-table .order-main-row td {
            height: 118px;
        }

        .order-items-table .order-detail-row td {
            background: #fff;
            padding: 24px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .order-product-img {
            width: 86px;
            height: 86px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            object-fit: contain;
            display: block;
        }

        .order-product-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--fg-dark);
            line-height: 1.4;
        }

        .order-qty,
        .order-unit-price {
            font-size: 15px;
            color: var(--fg-dark);
            white-space: nowrap;
        }

        .order-item-total-text {
            font-size: 16px;
            font-weight: 800;
            color: var(--fg-dark);
            white-space: nowrap;
        }

        .order-toggle-btn {
            border: 0;
            background: transparent;
            color: #1f4e79;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 0;
            white-space: nowrap;
        }

        .order-toggle-icon {
            width: 12px;
            height: 12px;
            object-fit: contain;
            transition: transform .2s ease;
        }

        .order-main-row.is-open .order-toggle-icon {
            transform: rotate(180deg);
        }

        .order-detail-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 70px;
        }

        .order-option-line {
            font-size: 14px;
            line-height: 1.75;
            color: var(--fg-dark);
        }

        .order-option-line strong {
            font-weight: 800;
        }

        .order-option-color {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, .14);
            vertical-align: middle;
            margin: 0 6px;
        }

        .order-detail-empty {
            color: var(--muted);
            font-size: 14px;
        }

        .order-detail-row.is-hidden {
            display: none;
        }

        @media (max-width: 900px) {
            .order-items-table-wrap {
                overflow-x: auto;
            }

            .order-items-table {
                min-width: 860px;
            }

            .order-detail-content {
                grid-template-columns: 1fr;
                gap: 6px;
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

        <div class="section-title">Order Information</div>

<table class="info-table">
    <tr>
        <th>Order No</th>
        <td>{{ $order->order_no }}</td>
    </tr>

    <tr>
        <th>Order Date</th>
        <td>
            {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}
        </td>
    </tr>

   
</table>

        <div class="section-title">Order Status</div>

        <form action="{{ route('admin.orders.updateStatus', $order->order_id) }}" method="POST" class="status-box">
            @csrf
            @method('PUT')

            <div class="status-form">
                <div class="form-group">
                    <label>Order Status</label>

                    <select name="status">
                        @foreach(['order_pending', 'design_in_progress', 'production', 'delivery', 'delivered', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Payment Status</label>

                    <select name="payment_status">
                        @foreach(['pending', 'paid', 'failed', 'cancelled', 'refunded'] as $paymentStatus)
                            <option value="{{ $paymentStatus }}" {{ $order->payment_status == $paymentStatus ? 'selected' : '' }}>
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

        <div class="order-items-table-wrap">
            <table class="order-items-table">
                <thead>
                    <tr>
                        <th style="width: 130px;">Image</th>
                        <th>Product</th>
                        <th style="width: 95px;">Qty</th>
                        <th style="width: 140px;">Unit Price</th>
                        <th style="width: 150px;">Total</th>
                        <th style="width: 150px; text-align: right;">
                            <img src="{{ asset('assets/images/icon/weui_arrow-filled (1).png') }}" class="order-toggle-icon" alt="">
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->items as $index => $item)
                        @php
                            $options = is_array($item->options)
                                ? $item->options
                                : json_decode($item->options ?? '[]', true);

                            $options = is_array($options) ? $options : [];

                            $leftOptions = [];
                            $rightOptions = [];

                            foreach ($options as $i => $option) {
                                if ($i % 2 === 0) {
                                    $leftOptions[] = $option;
                                } else {
                                    $rightOptions[] = $option;
                                }
                            }

                            $isOpen = $index === 0;
                        @endphp

                        <tr class="order-main-row {{ $isOpen ? 'is-open' : '' }}">
                            <td>
                                @if($item->product_image)
                                    <img src="{{ asset('storage/' . $item->product_image) }}" class="order-product-img" alt="">
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <div class="order-product-name">
                                    {{ $item->product_name_snapshot ?? $item->product_name }}
                                </div>
                            </td>

                            <td>
                                <span class="order-qty">
                                    {{ $item->qty ?? $item->quantity }}
                                </span>
                            </td>

                            <td>
                                <span class="order-unit-price">
                                    ¥ {{ number_format($item->unit_price, 2) }}
                                </span>
                            </td>

                            <td>
                                <span class="order-item-total-text">
                                    ¥ {{ number_format($item->item_total, 2) }}
                                </span>
                            </td>

                            <td style="text-align: right;">
                                <button type="button" class="order-toggle-btn">
                                    <img src="{{ asset('assets/images/icon/weui_arrow-filled (1).png') }}" class="order-toggle-icon" alt="">
                                    <span>View Details</span>
                                </button>
                            </td>
                        </tr>

                        <tr class="order-detail-row {{ $isOpen ? '' : 'is-hidden' }}">
                            <td colspan="6">
                                @if(!empty($options))
                                    <div class="order-detail-content">
                                        <div>
                                            @foreach($leftOptions as $option)
                                                <div class="order-option-line">
                                                    <strong>{{ $option['group_name'] ?? '-' }}:</strong>

                                                    @if(!empty($option['color_code']))
                                                        <span class="order-option-color"
                                                            style="background: {{ $option['color_code'] }}"></span>
                                                    @endif

                                                    {{ $option['option_name'] ?? '-' }}

                                                    @if(!empty($option['variant_name']))
                                                        : {{ $option['variant_name'] }}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <div>
                                            @foreach($rightOptions as $option)
                                                <div class="order-option-line">
                                                    <strong>{{ $option['group_name'] ?? '-' }}:</strong>

                                                    @if(!empty($option['color_code']))
                                                        <span class="order-option-color"
                                                            style="background: {{ $option['color_code'] }}"></span>
                                                    @endif

                                                    {{ $option['option_name'] ?? '-' }}

                                                    @if(!empty($option['variant_name']))
                                                        : {{ $option['variant_name'] }}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="order-detail-empty">
                                        No option details.
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.order-item-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    const card = this.closest('.order-item-card');
                    card.classList.toggle('is-open');
                });
            });
        });
    </script>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.order-toggle-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const mainRow = this.closest('.order-main-row');
                    const detailRow = mainRow.nextElementSibling;

                    if (!detailRow || !detailRow.classList.contains('order-detail-row')) {
                        return;
                    }

                    mainRow.classList.toggle('is-open');
                    detailRow.classList.toggle('is-hidden');
                });
            });
        });
    </script>
@endsection