<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.45;
            color: #111827;
            background: #fff;
            padding: 24px;
        }

        table { border-collapse: collapse; width: 100%; }

        /* ── Header ── */
        .header-table { margin-bottom: 20px; }
        .company-name { font-size: 15px; font-weight: 700; color: #111827; margin-bottom: 2px; }
        .company-email { font-size: 12px; color: #6b7280; }
        .invoice-title { font-size: 34px; font-weight: 700; letter-spacing: 1px; color: #111827; }
        .invoice-number { font-size: 12px; color: #374151; margin-top: 4px; }
        .invoice-date { font-size: 11px; color: #6b7280; margin-top: 2px; }

        /* ── Status badges ── */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid currentColor;
        }

        /* ── Info boxes ── */
        .info-box { border: 1px solid #d1d5db; padding: 12px 14px; }
        .info-box + .info-box { border-left: 0; }
        .box-label { font-size: 10px; color: #6b7280; letter-spacing: 0.8px; font-weight: 700; margin-bottom: 6px; text-transform: uppercase; }
        .box-name { font-size: 12px; font-weight: 700; margin-bottom: 4px; color: #111827; }
        .box-line { color: #374151; margin-bottom: 2px; }
        .box-muted { color: #6b7280; margin-top: 6px; }

        /* ── Items table ── */
        .items-table { border: 1px solid #d1d5db; margin-bottom: 16px; }
        .items-table thead tr { background: #f3f4f6; }
        .items-table th { padding: 8px 10px; text-align: left; font-size: 11px; color: #374151; border-bottom: 1px solid #d1d5db; }
        .items-table th.center { text-align: center; }
        .items-table th.right { text-align: right; }
        .items-table td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; color: #111827; }
        .items-table td.center { text-align: center; }
        .items-table td.right { text-align: right; }
        .items-table td.muted { color: #6b7280; }
        .items-table td.bold { font-weight: 700; }

        /* ── Totals ── */
        .totals-table { border: 1px solid #d1d5db; }
        .totals-table td { padding: 7px 10px; }
        .totals-table .label { color: #6b7280; }
        .totals-table .value { text-align: right; color: #111827; }
        .totals-table .total-row td { font-size: 13px; font-weight: 700; color: #111827; background: #f9fafb; }
        .totals-table .discount { color: #16a34a !important; }

        /* ── Notes ── */
        .notes-box { border: 1px solid #d1d5db; padding: 10px 12px; }
        .notes-label { font-size: 10px; color: #6b7280; letter-spacing: 0.8px; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; }
        .notes-text { font-size: 12px; color: #374151; }

        /* ── Footer ── */
        .footer { border-top: 1px solid #d1d5db; padding-top: 10px; text-align: center; color: #6b7280; font-size: 11px; margin-top: 14px; }

        /* ── Print ── */
        @media print {
            body { padding: 0; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body>

@php
    $statusMap = [
        'pending'    => '#f59e0b',
        'confirmed'  => '#2563eb',
        'processing' => '#4f46e5',
        'shipped'    => '#7c3aed',
        'delivered'  => '#16a34a',
        'cancelled'  => '#dc2626',
        'refunded'   => '#6b7280',
    ];
    $paymentMap = [
        'paid'               => '#16a34a',
        'unpaid'             => '#ca8a04',
        'pending'            => '#ca8a04',
        'failed'             => '#dc2626',
        'cancelled'          => '#dc2626',
        'refunded'           => '#6b7280',
        'partially_refunded' => '#ea580c',
        'authorized'         => '#2563eb',
    ];
    $statusColor  = $statusMap[$order->order_status->value]  ?? '#6b7280';
    $paymentColor = $paymentMap[$order->payment_status->value] ?? '#6b7280';
    $originalPrice = (float) $order->subtotal + (float) $order->shipping_amount + (float) $order->tax_amount;
    $methodLabel  = match ($order->payment_method) {
        \App\Enums\PaymentMethod::CreditCard    => 'Credit Card',
        \App\Enums\PaymentMethod::GooglePay     => 'Google Pay',
        \App\Enums\PaymentMethod::Paypal        => 'PayPal',
        \App\Enums\PaymentMethod::CashOnDelivery => 'Cash on Delivery',
    };
@endphp

{{-- Header --}}
<table class="header-table">
    <tr>
        <td style="width:45%; vertical-align:top;">
            @if(file_exists(public_path('assets/logo.png')))
                <img src="{{ asset('assets/logo.png') }}" alt="{{ $companyName }}" style="max-width:140px; height:auto; display:block; margin-bottom:8px;">
            @else
                <div style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:6px; background:#111827; color:#fff; font-weight:700; font-size:18px; margin-bottom:8px;">
                    {{ substr($companyName, 0, 1) }}
                </div>
            @endif
            <div class="company-name">{{ $companyName }}</div>
            <div class="company-email">{{ $companyEmail }}</div>
        </td>
        <td style="text-align:right; vertical-align:top;">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-number"><strong>#{{ $order->order_number }}</strong></div>
            <div class="invoice-date">{{ $order->placed_at?->format('d/m/Y') ?? $order->created_at->format('d/m/Y') }}</div>
            <div style="margin-top:8px;">
                <span class="badge" style="color:{{ $statusColor }};">{{ $order->order_status->name }}</span>
            </div>
        </td>
    </tr>
</table>

{{-- Bill To + Order Details --}}
<table style="margin-bottom:16px;">
    <tr>
        <td class="info-box" style="width:50%; vertical-align:top;">
            <div class="box-label">Bill To:</div>
            <div class="box-name">{{ trim($order->customer_first_name . ' ' . $order->customer_last_name) }}</div>
            @if($order->company_name)
                <div class="box-line">{{ $order->company_name }}</div>
            @endif
            <div class="box-line">{{ $order->customer_email }}</div>
            @if($order->customer_phone)
                <div class="box-line">{{ $order->customer_phone }}</div>
            @endif
            <div class="box-muted">
                {{ $order->street_address }}@if($order->apartment), {{ $order->apartment }}@endif<br>
                {{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}<br>
                {{ $order->country }}
            </div>
        </td>
        <td class="info-box" style="width:50%; vertical-align:top; border-left:0;">
            <div class="box-label">Order Details:</div>
            <table>
                <tr>
                    <td style="padding:3px 0; color:#6b7280;">Order Date</td>
                    <td style="padding:3px 0; text-align:right; color:#111827; font-weight:600;">{{ $order->placed_at?->format('d M Y') ?? $order->created_at->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td style="padding:3px 0; color:#6b7280;">Method</td>
                    <td style="padding:3px 0; text-align:right; color:#111827; font-weight:600;">{{ $methodLabel }}</td>
                </tr>
                <tr>
                    <td style="padding:3px 0; color:#6b7280;">Payment Status</td>
                    <td style="padding:3px 0; text-align:right;">
                        <span class="badge" style="color:{{ $paymentColor }};">{{ $order->payment_status->name }}</span>
                    </td>
                </tr>
                @if($order->transaction_id)
                    <tr>
                        <td style="padding:3px 0; color:#6b7280;">Transaction ID</td>
                        <td style="padding:3px 0; text-align:right; color:#111827; font-size:11px;">{{ $order->transaction_id }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

{{-- Items --}}
<table class="items-table">
    <thead>
        <tr>
            <th>PRODUCT NAME</th>
            <th>VARIANT</th>
            <th class="center" style="width:80px;">QUANTITY</th>
            <th class="right" style="width:110px;">UNIT PRICE</th>
            <th class="right" style="width:110px;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @forelse($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="muted">{{ $item->variant_label ?: '-' }}</td>
                <td class="center">{{ $item->quantity }}</td>
                <td class="right">${{ number_format((float) $item->unit_price, 2) }}</td>
                <td class="right bold">${{ number_format((float) $item->line_total, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#6b7280; padding:14px;">No items found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Notes + Totals --}}
<table>
    <tr>
        <td style="width:58%; vertical-align:top; padding-right:16px;">
            @if($order->order_notes)
                <div class="notes-box">
                    <div class="notes-label">Notes</div>
                    <div class="notes-text">{{ $order->order_notes }}</div>
                </div>
            @endif
        </td>
        <td style="width:42%; vertical-align:top;">
            <table class="totals-table">
                <tr>
                    <td class="label" style="border-bottom:1px solid #e5e7eb;">Original Price</td>
                    <td class="value" style="border-bottom:1px solid #e5e7eb;">${{ number_format($originalPrice, 2) }}</td>
                </tr>
                <tr>
                    <td class="label" style="border-bottom:1px solid #e5e7eb;">Subtotal</td>
                    <td class="value" style="border-bottom:1px solid #e5e7eb;">${{ number_format((float) $order->subtotal, 2) }}</td>
                </tr>
                @if((float) $order->shipping_amount > 0)
                    <tr>
                        <td class="label" style="border-bottom:1px solid #e5e7eb;">Shipping</td>
                        <td class="value" style="border-bottom:1px solid #e5e7eb;">${{ number_format((float) $order->shipping_amount, 2) }}</td>
                    </tr>
                @endif
                @if((float) $order->tax_amount > 0)
                    <tr>
                        <td class="label" style="border-bottom:1px solid #e5e7eb;">Tax</td>
                        <td class="value" style="border-bottom:1px solid #e5e7eb;">${{ number_format((float) $order->tax_amount, 2) }}</td>
                    </tr>
                @endif
                @if((float) $order->discount_amount > 0)
                    <tr>
                        <td class="label discount" style="border-bottom:1px solid #e5e7eb;">{{ $order->discount_label ?? 'Discount' }}</td>
                        <td class="value discount" style="border-bottom:1px solid #e5e7eb;">-${{ number_format((float) $order->discount_amount, 2) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>FINAL PAID AMOUNT</td>
                    <td style="text-align:right;">${{ number_format((float) $order->total_amount, 2) }} {{ $order->currency }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="footer">
    <div>Thank you for shopping with <strong>{{ $companyName }}</strong>.</div>
    <div style="margin-top:2px;">This is a computer-generated invoice and does not require a signature.</div>
</div>

<script>
    window.onload = function () {
        window.print();
    };
    window.addEventListener('afterprint', function () {
        window.close();
    });
</script>
</body>
</html>
