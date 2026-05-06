<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FashionHub · Order Confirmation #{{ $order->order_number }}</title>
    <!-- Bootstrap 5 + Icons + Google Fonts (Minimal luxury aesthetic) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700&display=swap"
        rel="stylesheet">
    <style>
        /* GLOBAL RESET: remove border-radius from all elements */
        * {
            border-radius: 0px !important;
        }

        body {
            background-color: #F4F4F6;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 32px 16px;
        }

        .email-flat {
            max-width: 640px;
            margin: 0 auto;
            background: #FFFFFF;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.03);
        }

        /* REFINED HEADER: Only right-side brand section (no image, minimalist) */
        .hero-text-only {
            background: #0A0A0C;
            padding: 40px 36px 36px 36px;
            text-align: left;
            border-bottom: 1px solid #2A2A2E;
        }

        .hero-badge {
            background: rgba(212, 184, 140, 0.12);
            padding: 4px 14px;
            display: inline-block;
            border: 0.5px solid rgba(212, 184, 140, 0.35);
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 500;
            color: #D4B88C;
            margin-bottom: 18px;
        }

        .hero-text-only h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2.4rem;
            letter-spacing: -0.5px;
            color: #F1E6D2;
            margin: 0 0 6px 0;
            line-height: 1.2;
        }

        .hero-tagline {
            color: #D4B88C;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 20px;
            opacity: 0.85;
        }

        .divider-gold {
            height: 2px;
            background-color: #D4B88C;
            width: 50px;
            margin: 18px 0 16px 0;
        }

        .hero-description {
            color: #EADBC8;
            font-size: 0.85rem;
            line-height: 1.45;
            margin-top: 8px;
            max-width: 85%;
        }

        .btn-track-flat {
            background-color: #FFFFFF;
            color: #0A0A0C;
            font-weight: 700;
            padding: 12px 34px;
            text-decoration: none;
            display: inline-block;
            border: 1px solid #D4B88C;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: all 0.2s ease;
        }

        .btn-track-flat:hover {
            background-color: #D4B88C;
            color: #0A0A0C;
            border-color: #D4B88C;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid #ECECE6;
        }

        .order-table th {
            background-color: #FCF9F4;
            font-weight: 700;
            padding: 14px 12px;
            border-bottom: 2px solid #E5DDD0;
            text-align: left;
            font-size: 0.8rem;
        }

        .order-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #F1EDE6;
            vertical-align: middle;
        }

        .order-table td:last-child,
        .order-table th:last-child {
            text-align: right;
        }

        .order-table td:nth-child(2),
        .order-table th:nth-child(2) {
            text-align: center;
        }

        .total-block {
            background: #FEFCF8;
            border: 1px solid #E9E2D6;
            padding: 16px 24px;
            text-align: right;
        }

        .contact-card-flat {
            background: #F9F6F0;
            border-left: 4px solid #C4A06A;
            padding: 20px 26px;
        }

        footer a {
            text-decoration: none;
            color: #7B6B59;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 560px) {
            .hero-text-only {
                padding: 32px 24px;
                text-align: center;
            }

            .hero-description {
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            .divider-gold {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-text-only h1 {
                font-size: 2rem;
            }

            .order-table th,
            .order-table td {
                padding: 10px 8px;
                font-size: 0.75rem;
            }

            body {
                padding: 16px 12px;
            }
        }
    </style>
</head>

<body
    style="background-color: #F4F4F6; font-family: 'Inter', 'Segoe UI', Helvetica, Arial, sans-serif; margin: 0; padding: 32px 16px;">

    <div class="email-flat"
        style="max-width: 640px; margin: 0 auto; background: #FFFFFF; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.03);">

        <!-- ========= REFINED HEADER: ONLY RIGHT SECTION / BRAND SECTION (NO IMAGE) ========= -->
        <div class="hero-text-only" style="background: #0A0A0C; padding: 42px 38px 38px 38px;">
            <div class="hero-badge"
                style="background: rgba(212, 184, 140, 0.12); padding: 5px 14px; display: inline-block; border: 0.5px solid rgba(212,184,140,0.4);">
                <span style="font-size: 0.65rem; letter-spacing: 1.5px; color: #D4B88C;">✦ ORDER CONFIRMED ✦</span>
            </div>
            <h1
                style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 2.4rem; letter-spacing: -0.5px; color: #F1E6D2; margin: 12px 0 4px;">
                FashionHub</h1>
            <div class="hero-tagline"
                style="color: #D4B88C; font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 8px;">CURATED LUXURY ·
                EXPRESS DELIVERY</div>
            <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 50px; margin: 18px 0 14px 0;">
            </div>
            <p class="hero-description" style="color: #EADBC8; font-size: 0.85rem; line-height: 1.45; margin-top: 6px;">
                Thank you for shopping with us. Your exclusive pieces are carefully packed and ready to ship.
            </p>
        </div>

        <!-- Order status & delivery announcement (flat, refined) -->
        <div style="padding: 28px 32px 12px 32px; background: white;">
            <div
                style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                <div>
                    <p style="margin: 0; font-size: 0.7rem; color: #7E6E5D;">ORDER REFERENCE</p>
                    <p style="font-weight: 800; font-size: 1rem; margin: 0;">#{{ $order->order_number }}</p>
                </div>
                <div style="background: #F3EFE9; padding: 5px 16px; border: 1px solid #E3DACF;">
                    <span style="font-weight: 600; color: #A67C4A; font-size: 0.7rem;"><i
                            class="bi bi-check2-circle"></i> {{ strtoupper($order->order_status?->name ?? $order->order_status) }}</span>
                </div>
            </div>

            <!-- Main delivery message -->
            <div style="margin: 16px 0 12px 0; background: #FCFAF5; padding: 20px 24px; border: 1px solid #EFE9E1;">
                <h2 style="font-weight: 700; font-size: 1.5rem; margin: 0 0 8px 0; color: #232120;">Your edit is on the
                    way</h2>
                <p style="margin-bottom: 6px; font-size: 0.9rem; color: #4C4238;">We received your order on
                    <strong>{{ $order->placed_at?->format('M j, Y') }}</strong>. We'll update you once it ships.
                </p>
                <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 45px; margin: 14px 0 12px 0;">
                </div>
                <p style="font-size: 0.85rem;"><span style="font-weight: 700;">Order number: #{{ $order->order_number }}</span>
                    &nbsp;|&nbsp; Placed: {{ $order->placed_at?->format('M j, Y · h:i A') }}</p>
            </div>

            <!-- Track CTA button (minimal, elevated) -->
            <div style="margin: 14px 0 12px 0;">
                <a href="{{ $orderUrl }}" class="btn-track-flat"
                    style="background: white; color: #1F1C19; border: 1.5px solid #D4B88C; padding: 11px 34px; font-weight: 600; text-decoration: none; display: inline-block;">VIEW
                    YOUR ORDER →</a>
            </div>
        </div>

        <!-- ========= ORDER SUMMARY (Luxury fashion items) ========= -->
        <div style="padding: 12px 32px 12px 32px;">
            <h3
                style="font-weight: 600; font-size: 1.2rem; margin-bottom: 20px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px; letter-spacing: -0.2px;">
                ORDER SUMMARY</h3>
            <div style="overflow-x: auto;">
                <table class="order-table" style="width: 100%; border-collapse: collapse; border: 1px solid #EDE7DF;">
                    <thead>
                        <tr style="background-color: #FCF9F4;">
                            <th style="padding: 14px 12px;">Item</th>
                            <th style="padding: 14px 12px; text-align: center;">Qty</th>
                            <th style="padding: 14px 12px; text-align: right;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td style="padding: 16px 12px;">
                                <strong>{{ $item->product_name }}</strong>
                                @if($item->variant_label)
                                <div style="font-size: 0.7rem; color: #8B7A68;">{{ $item->variant_label }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">${{ number_format($item->line_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals breakdown - elegant flat style -->
            <div class="total-block"
                style="margin-top: 26px; background: #FEFCF8; border: 1px solid #E9E2D6; padding: 16px 24px;">
                <div style="display: flex; justify-content: flex-end;">
                    <div style="min-width: 220px; text-align: right;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span
                                style="color:#6F5E4D;">Subtotal</span> <strong>${{ number_format($order->subtotal, 2) }}</strong></div>
                        @if($order->shipping_amount > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span
                                style="color:#6F5E4D;">Shipping</span> <strong>${{ number_format($order->shipping_amount, 2) }}</strong></div>
                        @endif
                        @if($order->tax_amount > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;"><span
                                style="color:#6F5E4D;">Tax</span> <strong>${{ number_format($order->tax_amount, 2) }}</strong></div>
                        @endif
                        @if($order->discount_amount > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;"><span
                            style="color:#6F5E4D;">{{ $order->discount_label ?? 'Discount' }}</span> <strong style="color:#c0392b;">-${{ number_format($order->discount_amount, 2) }}</strong></div>
                        @endif
                        <div style="height: 1px; background: #E1D8CD; margin: 8px 0 10px;"></div>
                        <div style="font-size: 1.2rem; font-weight: 800;">Total: <span
                                style="font-size: 1.6rem; color: #A67C4A; font-weight: 800;">${{ number_format($order->total_amount, 2) }}</span></div>
                        <p style="margin: 6px 0 0; font-size: 0.6rem; color: #8F7E6B;">Free 30-day returns &
                            carbon-neutral shipping</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stylist Note / upgraded service message -->
        <div style="padding: 8px 32px 12px 32px;">
            <div
                style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap; background: #FCFAF5; padding: 16px 22px; border: 1px solid #EFE9E1;">
                <i class="bi bi-star-fill" style="font-size: 1.3rem; color:#D4B88C;"></i>
                <span style="font-size: 0.75rem; font-weight: 500;">A personal styling note: each piece was
                    hand-selected. Track your shipment & enjoy express unboxing. ✨</span>
            </div>
        </div>

        <!-- ========= SUPPORT & STYLE CONCIERGE (elevated) ========= -->
        <div style="padding: 14px 32px 14px 32px;">
            <div class="contact-card-flat"
                style="background: #F9F6F0; border-left: 4px solid #C4A06A; padding: 20px 26px;">
                <h4 style="font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><i
                        class="bi bi-chat-quote-fill"></i> Fashion Concierge</h4>
                <p style="margin-bottom: 12px; font-size: 0.85rem;">Need assistance with sizing, returns, or gift
                    options? Reach us at <a href="mailto:{{ $supportEmail }}"
                        style="color: #A67C4A; text-decoration: underline;">{{ $supportEmail }}</a>@if($supportPhone) or call {{ $supportPhone }}@endif.</p>
                <div style="font-size: 0.7rem;">🕊️ Available Mon–Sun, 10am–9pm EST. Complimentary styling advice.</div>
            </div>
        </div>

        <!-- ========= FOOTER (sleek, minimal brand details) ========= -->
        <div style="background: #FFFFFF; padding: 28px 32px 36px 32px; border-top: 1px solid #EDE6DF;">
            <div style="text-align: center;">
                <div style="display: flex; justify-content: center; gap: 28px; margin-bottom: 20px; flex-wrap: wrap;">
                    <a href="#" style="color: #7D6A55; font-size: 0.75rem; text-decoration: none;"><i
                            class="bi bi-instagram"></i> Instagram</a>
                    <a href="#" style="color: #7D6A55; font-size: 0.75rem; text-decoration: none;"><i
                            class="bi bi-pinterest"></i> Pinterest</a>
                    <a href="#" style="color: #7D6A55; font-size: 0.75rem; text-decoration: none;"><i
                            class="bi bi-spotify"></i> Fashion Playlist</a>
                </div>
                <p style="font-size: 0.7rem; color: #8E7A64; margin-bottom: 8px;">
                    Copyright &copy; {{ date('Y') }} FashionHub. All rights reserved.
                </p>
                <p
                    style="font-size: 0.68rem; color: #9C8A74; max-width: 480px; margin-left: auto; margin-right: auto;">
                    You are receiving this because you placed an order on <a href="{{ $shopUrl }}"
                        style="color: #A67C4A;">FashionHub</a>.
                    <br>{{ $shopAddress }}
                </p>
                <p style="font-size: 0.6rem; margin-top: 16px;">
                    <a href="#" style="color: #8E7A64;">Update preferences</a> | <a href="#"
                        style="color: #8E7A64;">Unsubscribe from newsletters</a>
                </p>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
