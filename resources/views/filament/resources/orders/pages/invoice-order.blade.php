<x-filament-panels::page>
    <style>
        @media print {
            .fi-topbar,
            .fi-sidebar,
            .fi-page-header,
            .fi-breadcrumbs,
            .fi-header-actions,
            [class*="fi-btn"],
            .fi-notification-manager { display: none !important; }
            .fi-page-content { padding: 0 !important; margin: 0 !important; }
            @page { margin: 1cm; }

            /* Force readable colors on white paper */
            #invoice-print-wrapper,
            #invoice-print-wrapper * {
                color: #111827 !important;
                background: #fff !important;
                border-color: #d1d5db !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            #invoice-print-wrapper [data-badge] {
                background: transparent !important;
                border: 1px solid currentColor !important;
            }
        }
    </style>
    @php
        $statusMap = [
            'pending' => '#f59e0b',
            'confirmed' => '#2563eb',
            'processing' => '#4f46e5',
            'shipped' => '#7c3aed',
            'delivered' => '#16a34a',
            'cancelled' => '#dc2626',
            'refunded' => '#6b7280',
        ];

        $paymentMap = [
            'paid' => '#16a34a',
            'unpaid' => '#ca8a04',
            'pending' => '#ca8a04',
            'failed' => '#dc2626',
            'cancelled' => '#dc2626',
            'refunded' => '#6b7280',
            'partially_refunded' => '#ea580c',
            'authorized' => '#2563eb',
        ];

        $statusColor = $statusMap[$order->order_status->value] ?? '#6b7280';
        $paymentColor = $paymentMap[$order->payment_status->value] ?? '#6b7280';
        $originalPrice = (float) $order->subtotal + (float) $order->shipping_amount + (float) $order->tax_amount;

        $methodLabel = match ($order->payment_method) {
            \App\Enums\PaymentMethod::CreditCard => 'Credit Card',
            \App\Enums\PaymentMethod::GooglePay => 'Google Pay',
            \App\Enums\PaymentMethod::Paypal => 'PayPal',
            \App\Enums\PaymentMethod::CashOnDelivery => 'Cash on Delivery',
        };
    @endphp

    <div id="invoice-print-wrapper" style="width: 100%; max-width: none; margin: 0; background: rgba(255,255,255,0.06); padding: 28px; color: #e2e8f0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 1.45;">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 18px;">
            <tr>
                <td style="width: 40%; vertical-align: top;">
                    @if(file_exists(public_path('assets/logo.png')))
                        <img src="{{ asset('assets/logo.png') }}" alt="{{ $companyName }}" style="max-width: 140px; height: auto; display: block; margin-bottom: 8px;">
                    @else
                        <div style="display: inline-block; width: 40px; height: 40px; border-radius: 6px; background: #111827; color: #fff; text-align: center; line-height: 40px; font-weight: 700; font-size: 18px; margin-bottom: 8px;">
                            {{ substr($companyName, 0, 1) }}
                        </div>
                    @endif
                    <div style="font-size: 14px; font-weight: 700;">{{ $companyName }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">{{ $companyEmail }}</div>
                </td>
                <td style="width: 60%; text-align: right; vertical-align: top;">
                    <div style="font-size: 34px; letter-spacing: 1px; font-weight: 700; margin-bottom: 4px;">INVOICE</div>
                    <div style="font-size: 12px; color: #94a3b8;"><strong style="color: #e2e8f0;">#{{ $order->order_number }}</strong></div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">
                        {{ $order->placed_at?->format('d/m/Y') ?? $order->created_at->format('d/m/Y') }}
                    </div>
                    <div style="margin-top: 8px;">
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 999px; background: {{ $statusColor }}20; color: {{ $statusColor }}; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            {{ $order->order_status->name }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 18px;">
            <tr>
                <td style="width: 50%; vertical-align: top; border: 1px solid #e5e7eb54; padding: 12px 14px;">
                    <div style="font-size: 10px; color: #94a3b8; letter-spacing: 0.8px; font-weight: 700; margin-bottom: 6px;">BILL TO:</div>
                    <div style="font-size: 12px; font-weight: 700; margin-bottom: 4px;">{{ trim($order->customer_first_name . ' ' . $order->customer_last_name) }}</div>
                    @if($order->company_name)
                        <div style="color: #cbd5e1;">{{ $order->company_name }}</div>
                    @endif
                    <div style="color: #cbd5e1;">{{ $order->customer_email }}</div>
                    @if($order->customer_phone)
                        <div style="color: #cbd5e1;">{{ $order->customer_phone }}</div>
                    @endif
                    <div style="margin-top: 6px; color: #94a3b8;">
                        {{ $order->street_address }}@if($order->apartment), {{ $order->apartment }}@endif<br>
                        {{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}<br>
                        {{ $order->country }}
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top; border: 1px solid #e5e7eb54; border-left: 0; padding: 12px 14px;">
                    <div style="font-size: 10px; color: #94a3b8; letter-spacing: 0.8px; font-weight: 700; margin-bottom: 6px;">ORDER DETAILS:</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 2px 0; color: #94a3b8;">Order Date</td>
                            <td style="padding: 2px 0; text-align: right; color: #e2e8f0; font-weight: 600;">{{ $order->placed_at?->format('d M Y') ?? $order->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; color: #94a3b8;">Method</td>
                            <td style="padding: 2px 0; text-align: right; color: #e2e8f0; font-weight: 600;">{{ $methodLabel }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0; color: #94a3b8;">Payment Status</td>
                            <td style="padding: 2px 0; text-align: right;">
                                <span style="display: inline-block; padding: 2px 8px; border-radius: 999px; background: {{ $paymentColor }}20; color: {{ $paymentColor }}; font-size: 10px; font-weight: 700; text-transform: uppercase;">
                                    {{ $order->payment_status->name }}
                                </span>
                            </td>
                        </tr>
                        @if($order->transaction_id)
                            <tr>
                                <td style="padding: 2px 0; color: #94a3b8;">Transaction ID</td>
                                <td style="padding: 2px 0; text-align: right; color: #e2e8f0; font-size: 11px;">{{ $order->transaction_id }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 14px; border: 1px solid #e5e7eb54;">
            <thead>
                <tr style="background: rgba(255,255,255,0.21);;">
                    <th style="padding: 8px 10px; text-align: left; font-size: 11px;">PRODUCT NAME</th>
                    <th style="padding: 8px 10px; text-align: left; font-size: 11px;">VARIANT</th>
                    <th style="padding: 8px 10px; text-align: center; font-size: 11px; width: 80px;">QUANTITY</th>
                    <th style="padding: 8px 10px; text-align: right; font-size: 11px; width: 110px;">UNIT PRICE</th>
                    <th style="padding: 8px 10px; text-align: right; font-size: 11px; width: 110px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $item)
                    <tr>
                        <td style="padding: 8px 10px; border-bottom: 1px solid #e5e7eb54; color: #e2e8f0;">{{ $item->product_name }}</td>
                        <td style="padding: 8px 10px; border-bottom: 1px solid #e5e7eb54; color: #94a3b8;">{{ $item->variant_label ?: '-' }}</td>
                        <td style="padding: 8px 10px; border-bottom: 1px solid #e5e7eb54; text-align: center; color: #e2e8f0;">{{ $item->quantity }}</td>
                        <td style="padding: 8px 10px; border-bottom: 1px solid #e5e7eb54; text-align: right; color: #e2e8f0;">${{ number_format((float) $item->unit_price, 2) }}</td>
                        <td style="padding: 8px 10px; border-bottom: 1px solid #e5e7eb54; text-align: right; color: #e2e8f0; font-weight: 700;">${{ number_format((float) $item->line_total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 14px; text-align: center; color: #94a3b8;">No items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 14px;">
            <tr>
                <td style="width: 62%; vertical-align: top; padding-right: 16px;">
                    @if($order->order_notes)
                        <div style="border: 1px solid #e5e7eb54; padding: 10px 12px;">
                            <div style="font-size: 10px; color: #94a3b8; letter-spacing: 0.8px; font-weight: 700; margin-bottom: 4px;">NOTES</div>
                            <div style="font-size: 12px; color: #cbd5e1;">{{ $order->order_notes }}</div>
                        </div>
                    @endif
                </td>
                <td style="width: 38%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb54;">
                        <tr>
                            <td style="padding: 8px 10px; color: #94a3b8; border-bottom: 1px solid #e5e7eb54;">Original Price</td>
                            <td style="padding: 8px 10px; color: #e2e8f0; border-bottom: 1px solid #e5e7eb54; text-align: right;">${{ number_format($originalPrice, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 10px; color: #94a3b8; border-bottom: 1px solid #e5e7eb54;">Subtotal</td>
                            <td style="padding: 8px 10px; color: #e2e8f0; border-bottom: 1px solid #e5e7eb54; text-align: right;">${{ number_format((float) $order->subtotal, 2) }}</td>
                        </tr>
                        @if((float) $order->shipping_amount > 0)
                            <tr>
                                <td style="padding: 8px 10px; color: #94a3b8; border-bottom: 1px solid #e5e7eb54;">Shipping</td>
                                <td style="padding: 8px 10px; color: #e2e8f0; border-bottom: 1px solid #e5e7eb54; text-align: right;">${{ number_format((float) $order->shipping_amount, 2) }}</td>
                            </tr>
                        @endif
                        @if((float) $order->tax_amount > 0)
                            <tr>
                                <td style="padding: 8px 10px; color: #94a3b8; border-bottom: 1px solid #e5e7eb54;">Tax</td>
                                <td style="padding: 8px 10px; color: #e2e8f0; border-bottom: 1px solid #e5e7eb54; text-align: right;">${{ number_format((float) $order->tax_amount, 2) }}</td>
                            </tr>
                        @endif
                        @if((float) $order->discount_amount > 0)
                            <tr>
                                <td style="padding: 8px 10px; color: #16a34a; border-bottom: 1px solid #e5e7eb54;">{{ $order->discount_label ?? 'Discount' }}</td>
                                <td style="padding: 8px 10px; color: #16a34a; border-bottom: 1px solid #e5e7eb54; text-align: right;">-${{ number_format((float) $order->discount_amount, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="padding: 10px; color: #e2e8f0; font-size: 13px; font-weight: 700;">FINAL PAID AMOUNT</td>
                            <td style="padding: 10px; color: #e2e8f0; font-size: 13px; font-weight: 700; text-align: right;">${{ number_format((float) $order->total_amount, 2) }} {{ $order->currency }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div style="border-top: 1px solid #e5e7eb54; padding-top: 10px; text-align: center; color: #94a3b8; font-size: 11px;">
            <div style="margin-bottom: 2px;">Thank you for shopping with {{ $companyName }}.</div>
            <div>This is a computer-generated invoice and does not require a signature.</div>
        </div>
    </div>
</x-filament-panels::page>
