<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="margin:0; padding:0; background:#f5f6f8; font-family:Arial, sans-serif; color:#111;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6f8; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="680" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:10px; overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px; background:#1f4bbb; color:#fff;">
                            <h1 style="margin:0; font-size:26px;">Pedido Confirmado!</h1>
                            <p style="margin:8px 0 0; font-size:14px;">
                                Obrigado pelo seu pedido. Recebemos sua solicitação com sucesso.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 32px;">
                            <h2 style="margin:0 0 12px; font-size:20px;">Order Summary</h2>

                            <p><strong>Order No:</strong> {{ $order->order_no }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($order->status ?? 'pending') }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</p>

                            <hr style="border:0; border-top:1px solid #e5e7eb; margin:20px 0;">

                            <h3 style="margin:0 0 14px; font-size:18px;">Items</h3>

                            @foreach($order->items as $item)
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:18px; border-bottom:1px solid #eee; padding-bottom:16px;">
                                    <tr>
                                        <td width="90" valign="top">
                                            @if($item->product_image)
                                                <img src="{{ asset('storage/' . $item->product_image) }}"
                                                    width="76"
                                                    height="76"
                                                    style="object-fit:contain; border:1px solid #e5e7eb; border-radius:6px;"
                                                    alt="{{ $item->product_name_snapshot ?? $item->product_name }}">
                                            @endif
                                        </td>

                                        <td valign="top" style="padding-left:12px;">
                                            <div style="font-size:16px; font-weight:bold; margin-bottom:6px;">
                                                {{ $item->product_name_snapshot ?? $item->product_name }}
                                            </div>

                                            <div style="font-size:13px; margin-bottom:4px;">
                                                Quantity: {{ $item->qty ?? $item->quantity }}
                                            </div>

                                            <div style="font-size:13px; margin-bottom:8px;">
                                                Unit Price: ¥ {{ number_format($item->unit_price ?? 0, 2) }}
                                            </div>

                                            @if($item->optionDetails && $item->optionDetails->count())
                                                <div style="font-size:13px; line-height:1.6;">
                                                    <strong>Options:</strong><br>

                                                    @foreach($item->optionDetails->groupBy('group_name_snapshot') as $groupName => $options)
                                                        <div>
                                                            <strong>{{ $groupName }}:</strong>
                                                            @foreach($options as $option)
                                                                {{ $option->custom_value ?: $option->option_name_snapshot }}
                                                                @if(!$loop->last), @endif
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>

                                        <td width="110" valign="top" align="right">
                                            <strong>
                                                ¥ {{ number_format($item->item_total ?? 0, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            @endforeach

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px;">
                                <tr>
                                    <td align="right" style="font-size:15px; padding:5px 0;">Subtotal:</td>
                                    <td align="right" width="130" style="font-size:15px; padding:5px 0;">
                                        ¥ {{ number_format($order->subtotal ?? 0, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right" style="font-size:15px; padding:5px 0;">VAT:</td>
                                    <td align="right" width="130" style="font-size:15px; padding:5px 0;">
                                        ¥ {{ number_format($order->vat_amount ?? 0, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right" style="font-size:15px; padding:5px 0;">Shipping:</td>
                                    <td align="right" width="130" style="font-size:15px; padding:5px 0;">
                                        ¥ {{ number_format($order->shipping_fee ?? 0, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right" style="font-size:18px; font-weight:bold; padding:10px 0;">
                                        Grand Total:
                                    </td>
                                    <td align="right" width="130" style="font-size:18px; font-weight:bold; padding:10px 0;">
                                        ¥ {{ number_format($order->grand_total ?? 0, 2) }}
                                    </td>
                                </tr>
                            </table>

                            <hr style="border:0; border-top:1px solid #e5e7eb; margin:22px 0;">

                            <h3 style="margin:0 0 10px; font-size:18px;">Customer Information</h3>

                            @if($order->customer)
                                <p style="font-size:14px; line-height:1.7; margin:0;">
                                    <strong>Name:</strong>
                                    {{ $order->customer->personal_first_name ?? '' }}
                                    {{ $order->customer->personal_last_name ?? '' }}<br>

                                    <strong>Email:</strong>
                                    {{ $order->customer->personal_email ?? '-' }}<br>

                                    <strong>Phone:</strong>
                                    {{ $order->customer->personal_phone ?? '-' }}<br>

                                    <strong>Shipping Address:</strong><br>
                                    {{ $order->customer->shipping_building_room ?? '' }}<br>
                                    {{ $order->customer->shipping_area ?? '' }}
                                    {{ $order->customer->shipping_city ?? '' }}<br>
                                    {{ $order->customer->shipping_province ?? '' }}
                                    {{ $order->customer->shipping_postcode ?? '' }}
                                </p>
                            @endif

                            <p style="font-size:13px; color:#666; margin-top:24px;">
                                We will notify you again once your order status is updated.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>