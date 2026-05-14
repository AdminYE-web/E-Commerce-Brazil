@extends('layouts.app')

@section('title', 'Your Orders')

@section('css')
<style>
    .account-page {
        background: #f3f3f3;
        padding: 32px 0;
        min-height: 720px;
    }

    .account-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 36px;
        align-items: start;
    }

    .orders-card {
        background: #fff;
        border-radius: 8px;
        padding: 36px 54px;
        min-height: 520px;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 18px;
    }

    .orders-header h1 {
        font-size: 34px;
        font-weight: 700;
        margin: 0;
    }

    .order-search-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .order-search-input {
        width: 260px;
        height: 34px;
        border: 1px solid #111;
        border-radius: 9px;
        padding: 0 14px;
        font-size: 14px;
    }

    .order-search-btn {
        height: 34px;
        padding: 0 16px;
        border: 0;
        border-radius: 999px;
        background: #2f70c9;
        color: #fff;
        font-weight: 700;
    }

    .order-tabs {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #e5e5e5;
        margin-bottom: 36px;
    }

    .order-tabs a {
        padding: 10px 16px;
        color: #111;
        text-decoration: none;
        font-size: 15px;
        border-bottom: 3px solid transparent;
    }

    .order-tabs a.active {
        color: #111;
        font-weight: 700;
        border-bottom-color: #2f8cff;
    }

    .order-card {
        border: 1px solid #cfcfcf;
        border-radius: 9px;
        padding: 26px 26px;
        margin-bottom: 20px;
        display: grid;
        grid-template-columns: 160px 1fr 190px;
        gap: 18px;
        align-items: start;
    }

    .order-img {
        width: 160px;
        height: 160px;
        border: 1px solid #d7d7d7;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #fff;
    }

    .order-img img {
        max-width: 145px;
        max-height: 145px;
        object-fit: contain;
    }

    .order-category {
        color: #555;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .order-product-name {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 40px;
        line-height: 1.2;
    }

    .order-basic-line {
        font-size: 15px;
        margin-bottom: 12px;
    }

    .order-right {
        text-align: right;
        font-size: 15px;
    }

    .order-status {
        color: #1683ff;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .order-no,
    .order-date {
        margin-bottom: 14px;
    }

    .order-price {
        font-weight: 800;
        font-size: 17px;
        margin-bottom: 26px;
    }

    .details-btn {
        border: 0;
        background: transparent;
        color: #1d5fd1;
        font-size: 15px;
        cursor: pointer;
        padding: 0;
    }

    .details-btn .arrow {
        /* display: inline-block;
        width: 12px;
        height: 12px; */
        margin-right: 4px;
        vertical-align: -1px;
        transition: transform .2s ease;
    }

    .details-btn.is-open .arrow {
        transform: rotate(180deg);
    }

    .order-details {
        grid-column: 2 / 4;
        display: none;
        padding-top: 10px;
    }

    .order-details.is-open {
        display: block;
    }

    .option-row {
        margin-bottom: 26px;
        font-size: 15px;
        line-height: 1.6;
    }

    .option-label {
        color: #111;
        margin-bottom: 3px;
    }

    .option-value {
        color: #111;
    }

    .empty-orders {
        color: #777;
        padding: 30px 0;
    }

    @media (max-width: 991px) {
        .account-layout {
            grid-template-columns: 1fr;
        }

        .orders-card {
            padding: 28px 20px;
        }

        .orders-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-tabs {
            overflow-x: auto;
            gap: 20px;
            justify-content: flex-start;
        }

        .order-card {
            grid-template-columns: 1fr;
        }

        .order-right {
            text-align: left;
        }

        .order-details {
            grid-column: auto;
        }
    }
</style>
@endsection

@section('content')
<div class="account-page">
    <div class="container">
        <div class="account-layout">

            @include('account.partials.sidebar', ['user' => $user])

            <main class="orders-card">
                <div class="orders-header">
                    <h1>Your Orders</h1>

                    <form method="GET" action="{{ route('account.orders.index') }}" class="order-search-form">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="order-search-input"
                            placeholder="Search all orders"
                        >

                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <button type="submit" class="order-search-btn">
                            Search Orders
                        </button>
                    </form>
                </div>

                @php
                    $tabs = [
                        'all' => 'All Orders',
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ];

                    $currentStatus = request('status', 'all');
                @endphp

                <div class="order-tabs">
                    @foreach($tabs as $tabKey => $tabLabel)
                        <a href="{{ route('account.orders.index', array_filter([
                                'status' => $tabKey === 'all' ? null : $tabKey,
                                'search' => request('search'),
                            ])) }}"
                            class="{{ $currentStatus === $tabKey || (!$currentStatus && $tabKey === 'all') ? 'active' : '' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </div>

                @forelse($orders as $order)
                    @foreach($order->items as $item)
                        @php
                            $detailId = 'order-detail-' . $order->order_id . '-' . $item->order_item_id;

                            $productImage = $item->product_image
                                ? asset('storage/' . $item->product_image)
                                : asset('images/no-image.png');

                            $qty = $item->qty ?? $item->quantity ?? 0;
                            $itemTotal = $item->item_total ?? 0;

                            $statusText = ucfirst($order->status ?? 'pending');

                            $optionsGrouped = $item->optionDetails
                                ->groupBy('group_name_snapshot');
                        @endphp

                        <div class="order-card">
                            <div class="order-img">
                                <img src="{{ $productImage }}" alt="{{ $item->product_name_snapshot ?? $item->product_name }}">
                            </div>

                            <div class="order-main">
                                <div class="order-category">
                                    {{ $item->category_name_snapshot ?? 'Lanyard' }}
                                </div>

                                <div class="order-product-name">
                                    {{ $item->product_name_snapshot ?? $item->product_name }}
                                </div>

                                <div class="order-basic-line">
                                    Quantity : {{ number_format($qty) }}
                                </div>
                            </div>

                            <div class="order-right">
                                <div class="order-status">
                                    {{ $statusText }}
                                </div>

                                <div class="order-no">
                                    {{ $order->order_no }}
                                </div>

                                <div class="order-date">
                                    {{ $order->created_at ? $order->created_at->format('M d, Y') : '-' }}
                                </div>

                                <div class="order-price">
                                    ¥ {{ number_format($itemTotal, 2) }}
                                </div>

                                <button type="button" class="details-btn" data-target="#{{ $detailId }}">
                                    <img class="arrow" src="{{ asset('assets/images/icon/weui_arrow-filled.png') }}" alt="" aria-hidden="true"> Details
                                </button>
                            </div>

                            <div class="order-details" id="{{ $detailId }}">
                                @forelse($optionsGrouped as $groupName => $options)
                                    <div class="option-row">
                                        <div class="option-label">
                                            {{ $groupName ?: 'Option' }}
                                        </div>

                                        <div class="option-value">
                                            @foreach($options as $option)
                                                {{ $option->custom_value ?: $option->option_name_snapshot }}
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="option-row">
                                        No option details.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="empty-orders">
                        No orders found.
                    </div>
                @endforelse

                <div style="margin-top: 20px;">
                    {{ $orders->links() }}
                </div>
            </main>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.details-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.dataset.target);

            if (!target) {
                return;
            }

            target.classList.toggle('is-open');
            this.classList.toggle('is-open');
        });
    });
});
</script>
@endsection
