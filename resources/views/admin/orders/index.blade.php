@extends('admin.layouts.app')

@section('title', 'Orders | Indigo Admin')

@section('css')
<style>
    .alert-success {
        margin-bottom: 18px;
        padding: 12px 16px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        font-size: 14px;
    }

    .filter-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding: 16px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 12px;
    }

    .filter-form input,
    .filter-form select {
        height: 38px;
        padding: 0 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: #fff;
        font-family: inherit;
        font-size: 14px;
    }

    .filter-form input {
        min-width: 280px;
        flex: 1;
    }

    .order-no {
        font-weight: 700;
        color: var(--fg-dark);
    }

    .customer-text {
        line-height: 1.5;
    }

    .customer-sub {
        display: block;
        color: var(--muted);
        font-size: 12px;
    }

    .amount-text {
        font-weight: 700;
        color: var(--fg-dark);
        white-space: nowrap;
    }

    .status-badge {
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
        white-space: nowrap;
    }

    .payment-sub {
        display: block;
        margin-top: 4px;
        color: var(--muted);
        font-size: 12px;
    }

    .date-text {
        white-space: nowrap;
        color: var(--fg);
        font-size: 13px;
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
        cursor: pointer;
        font-family: inherit;
        border: 1px solid transparent;
    }

    .btn-outline {
        background: #fff;
        border-color: var(--border);
        color: var(--fg);
    }

    .btn-primary {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    @media (max-width: 900px) {
        .table-card {
            overflow-x: auto;
        }

        table {
            min-width: 1100px;
        }

        .filter-form {
            flex-direction: column;
        }

        .filter-form input,
        .filter-form select,
        .filter-form .btn-primary,
        .filter-form .btn-outline {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Orders</div>
            <div class="showing-text">
                Manage customer orders, payment status and order progress.
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="filter-form">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search order no, email, name, phone"
        >

        <select name="status">
            <option value="">All Order Status</option>
            @foreach(['pending','confirmed','paid','processing','completed','cancelled'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <select name="payment_status">
            <option value="">All Payment Status</option>
            @foreach(['pending','paid','failed','cancelled','refunded'] as $paymentStatus)
                <option value="{{ $paymentStatus }}" {{ request('payment_status') == $paymentStatus ? 'selected' : '' }}>
                    {{ ucfirst($paymentStatus) }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-primary">
            Search
        </button>

        <a href="{{ route('admin.orders.index') }}" class="btn-outline">
            Reset
        </a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th style="text-align:right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>
                        <span class="order-no">
                            {{ $order->order_no }}
                        </span>
                    </td>

                    <td>
                        <div class="customer-text">
                            {{ $order->customer->personal_first_name ?? '-' }}
                            {{ $order->customer->personal_last_name ?? '' }}

                            <span class="customer-sub">
                                {{ $order->customer->personal_email ?? '-' }}
                            </span>
                        </div>
                    </td>

                    <td>{{ $order->qty }}</td>

                    <td>
                        <span class="amount-text">
                            ¥ {{ number_format($order->grand_total, 2) }}
                        </span>
                    </td>

                    <td>
                        <span class="status-badge">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td>
                        <span class="status-badge">
                            {{ ucfirst($order->payment->payment_status ?? 'pending') }}
                        </span>

                        <span class="payment-sub">
                            {{ $order->payment->payment_method ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <span class="date-text">
                            {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </td>

                    <td style="text-align:right;">
                        <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn-outline">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:32px;">
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $orders->links() }}
    </div>
</div>

@endsection