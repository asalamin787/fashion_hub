<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FashionHub · Payment Confirmation | Transaction Receipt</title>
    <!-- Bootstrap 5 + Icons + Google Fonts (Luxury, minimal) -->
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

        /* Header section - brand only (no image) */
        .header-payment {
            background: #0A0A0C;
            padding: 38px 38px 32px 38px;
            text-align: left;
            border-bottom: 1px solid #2A2A2E;
        }

        .payment-badge {
            background: rgba(76, 175, 80, 0.12);
            padding: 4px 14px;
            display: inline-block;
            border: 0.5px solid rgba(76, 175, 80, 0.35);
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: #4CAF50;
            margin-bottom: 18px;
        }

        .header-payment h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2.2rem;
            letter-spacing: -0.5px;
            color: #F1E6D2;
            margin: 0 0 6px 0;
            line-height: 1.2;
        }

        .header-tagline {
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

        .payment-success-icon {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(76, 175, 80, 0.08);
            padding: 8px 18px;
            margin-top: 12px;
        }

        .btn-view-order {
            background-color: #FFFFFF;
            color: #0A0A0C;
            font-weight: 700;
            padding: 12px 32px;
            text-decoration: none;
            display: inline-block;
            border: 1px solid #D4B88C;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .btn-view-order:hover {
            background-color: #D4B88C;
            color: #0A0A0C;
            border-color: #D4B88C;
        }

        .payment-summary-card {
            background: #F8F9FC;
            border: 1px solid #E9EDF2;
            padding: 20px 24px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #EEF2F8;
        }

        .info-row:last-child {
            border-bottom: none;
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
            padding: 12px 12px;
            border-bottom: 2px solid #E5DDD0;
            text-align: left;
            font-size: 0.75rem;
        }

        .order-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #F1EDE6;
            vertical-align: middle;
            font-size: 0.85rem;
        }

        .order-table td:last-child,
        .order-table th:last-child {
            text-align: right;
        }

        .order-table td:nth-child(2),
        .order-table th:nth-child(2) {
            text-align: center;
        }

        .total-amount-large {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1A4D3A;
        }

        footer a {
            text-decoration: none;
            color: #7B6B59;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 560px) {
            .header-payment {
                padding: 28px 24px;
                text-align: center;
            }

            .divider-gold {
                margin-left: auto;
                margin-right: auto;
            }

            .payment-success-icon {
                justify-content: center;
            }

            .order-table th,
            .order-table td {
                padding: 8px 6px;
                font-size: 0.7rem;
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

        <!-- ========= HEADER: PAYMENT CONFIRMATION BRAND SECTION ========= -->
        <div class="header-payment" style="background: #0A0A0C; padding: 38px 38px 32px 38px;">
            <div class="payment-badge"
                style="background: rgba(76, 175, 80, 0.12); padding: 5px 14px; display: inline-block; border: 0.5px solid rgba(76,175,80,0.35);">
                <span style="font-size: 0.65rem; letter-spacing: 1.5px; color: #4CAF50;">✓ PAYMENT RECEIVED</span>
            </div>
            <h1
                style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 2.2rem; letter-spacing: -0.5px; color: #F1E6D2; margin: 12px 0 4px;">
                FashionHub</h1>
            <div class="header-tagline"
                style="color: #D4B88C; font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 6px;">PAYMENT CONFIRMATION
                · TRANSACTION COMPLETED</div>
            <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 50px; margin: 18px 0 14px 0;">
            </div>
            <div class="payment-success-icon"
                style="display: inline-flex; align-items: center; gap: 8px; background: rgba(76,175,80,0.08); padding: 8px 18px; margin-top: 10px;">
                <i class="bi bi-check-circle-fill" style="color: #4CAF50; font-size: 1rem;"></i>
                <span style="color: #EADBC8; font-size: 0.8rem; font-weight: 500;">Your payment has been successfully
                    processed</span>
            </div>
        </div>

        <!-- Payment confirmation message & details -->
        <div style="padding: 28px 32px 20px 32px; background: white;">
            <div
                style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <p style="margin: 0; font-size: 0.7rem; color: #7E6E5D;">TRANSACTION ID</p>
                    <p style="font-weight: 800; font-size: 0.95rem; margin: 0; letter-spacing: 0.3px;">TXN-FH-4X9K-2M7P
                    </p>
                </div>
                <div style="background: #E8F5E9; padding: 5px 16px; border: 1px solid #C8E6C9;">
                    <span style="font-weight: 600; color: #2E7D32; font-size: 0.7rem;"><i
                            class="bi bi-check2-circle"></i> PAID IN FULL</span>
                </div>
            </div>

            <!-- Success message -->
            <div style="margin: 8px 0 16px 0; background: #FCFAF5; padding: 20px 24px; border: 1px solid #EFE9E1;">
                <h2 style="font-weight: 700; font-size: 1.3rem; margin: 0 0 8px 0; color: #232120;">Thank you for your
                    payment</h2>
                <p style="margin-bottom: 6px; font-size: 0.9rem; color: #4C4238;">Your payment of
                    <strong>$784.75</strong> was successfully charged on <strong>May 4, 2026</strong> at 11:42 AM EST.
                </p>
                <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 45px; margin: 16px 0 12px 0;">
                </div>
                <p style="font-size: 0.8rem; color: #5D6E5F;">A receipt has been sent to
                    <strong>alex.morgan@fashionhub.com</strong>. Your order is now being prepared for shipment.</p>
            </div>

            <!-- View Order Button -->
            <div style="margin: 8px 0 16px 0;">
                <a href="#" class="btn-view-order"
                    style="background: white; color: #1F1C19; border: 1.5px solid #D4B88C; padding: 11px 34px; font-weight: 600; text-decoration: none; display: inline-block;">VIEW
                    ORDER DETAILS →</a>
            </div>
        </div>

        <!-- ========= PAYMENT SUMMARY CARD ========= -->
        <div style="padding: 0px 32px 12px 32px;">
            <h3
                style="font-weight: 600; font-size: 1rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                PAYMENT SUMMARY</h3>
            <div class="payment-summary-card"
                style="background: #F8F9FC; border: 1px solid #E9EDF2; padding: 20px 24px;">
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Payment Method</span>
                    <span><strong>Visa •••• 4242</strong> (Credit Card)</span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Transaction Date</span>
                    <span>May 4, 2026 · 11:42 AM EST</span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Authorization Code</span>
                    <span><strong>FH-AUTH-8723G</strong></span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Payment Status</span>
                    <span style="color: #2E7D32; font-weight: 600;">✓ Captured / Settled</span>
                </div>
                <div class="info-row" style="display: flex; justify-content: space-between; padding: 12px 0 4px 0;">
                    <span style="font-weight: 700; font-size: 1rem;">Total Charged</span>
                    <span class="total-amount-large"
                        style="font-size: 1.5rem; font-weight: 800; color: #1A4D3A;">$784.75</span>
                </div>
            </div>
        </div>

        <!-- ========= ORDER SUMMARY (items purchased) ========= -->
        <div style="padding: 20px 32px 12px 32px;">
            <h3
                style="font-weight: 600; font-size: 1rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                ORDERED ITEMS</h3>
            <div style="overflow-x: auto;">
                <table class="order-table" style="width: 100%; border-collapse: collapse; border: 1px solid #EDE7DF;">
                    <thead>
                        <tr style="background-color: #FCF9F4;">
                            <th style="padding: 12px 12px;">Item</th>
                            <th style="padding: 12px 12px; text-align: center;">Qty</th>
                            <th style="padding: 12px 12px; text-align: right;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 14px 12px;">
                                <strong>Cashmere Blend Wrap Coat</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Camel · Size M</div>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">$289.00</td>
                        </tr>
                        <tr>
                            <td style="padding: 14px 12px;">
                                <strong>Leather Stiletto Boots</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Black · Size 38 EU</div>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">$179.00</td>
                        </tr>
                        <tr>
                            <td style="padding: 14px 12px;">
                                <strong>Silk Satin Slip Dress</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Champagne · Size S</div>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">$149.00</td>
                        </tr>
                        <tr style="border-bottom: none;">
                            <td style="padding: 14px 12px;">
                                <strong>Gold-Toned Hoop Earrings</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Limited Edition</div>
                            </td>
                            <td style="text-align: center;">2</td>
                            <td style="text-align: right;">$98.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Totals breakdown -->
            <div style="margin-top: 20px; background: #FEFCF8; border: 1px solid #E9E2D6; padding: 16px 24px;">
                <div style="display: flex; justify-content: flex-end;">
                    <div style="min-width: 220px; text-align: right;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span
                                style="color:#6F5E4D;">Subtotal</span> <strong>$715.00</strong></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span
                                style="color:#6F5E4D;">Express Shipping</span> <strong>$15.00</strong></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;"><span
                                style="color:#6F5E4D;">Tax (7.5%)</span> <strong>$54.75</strong></div>
                        <div style="height: 1px; background: #E1D8CD; margin: 8px 0 10px;"></div>
                        <div style="font-size: 1.1rem; font-weight: 800;">Total Charged: <span
                                style="font-size: 1.5rem; color: #1A4D3A; font-weight: 800;">$784.75</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing Information Section -->
        <div style="padding: 8px 32px 12px 32px;">
            <div
                style="display: flex; flex-wrap: wrap; gap: 20px; background: #FCFAF5; padding: 20px 24px; border: 1px solid #EFE9E1;">
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D; letter-spacing: 0.5px;">BILLING
                        ADDRESS</p>
                    <p style="margin: 0; font-size: 0.8rem; line-height: 1.4;">
                        Alex Morgan<br>
                        450 Fifth Avenue, Suite 4<br>
                        New York, NY 10018<br>
                        United States
                    </p>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D; letter-spacing: 0.5px;">SHIPPING
                        ADDRESS</p>
                    <p style="margin: 0; font-size: 0.8rem; line-height: 1.4;">
                        Alex Morgan<br>
                        450 Fifth Avenue, Suite 4<br>
                        New York, NY 10018<br>
                        United States
                    </p>
                </div>
            </div>
        </div>

        <!-- ========= SUPPORT SECTION ========= -->
        <div style="padding: 14px 32px 14px 32px;">
            <div style="background: #F9F6F0; border-left: 4px solid #C4A06A; padding: 20px 26px;">
                <h4 style="font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><i
                        class="bi bi-headset"></i> Need assistance?</h4>
                <p style="margin-bottom: 8px; font-size: 0.85rem;">If you have any questions about your payment or
                    order, please contact our support team.</p>
                <p style="margin: 0; font-size: 0.8rem;">
                    📧 <a href="mailto:payments@fashionhub.com"
                        style="color: #A67C4A; text-decoration: underline;">payments@fashionhub.com</a> &nbsp;|&nbsp;
                    📞 +1 (212) 555 8273
                </p>
            </div>
        </div>

        <!-- ========= FOOTER ========= -->
        <div style="background: #FFFFFF; padding: 28px 32px 36px 32px; border-top: 1px solid #EDE6DF;">
            <div style="text-align: center;">
                <div style="display: flex; justify-content: center; gap: 28px; margin-bottom: 20px; flex-wrap: wrap;">
                    <a href="#" style="color: #7D6A55; font-size: 0.75rem; text-decoration: none;"><i
                            class="bi bi-instagram"></i> Instagram</a>
                    <a href="#" style="color: #7D6A55; font-size: 0.75rem; text-decoration: none;"><i
                            class="bi bi-pinterest"></i> Pinterest</a>
                    <a href="#" style="color: #7D6A55; font-size: 0.75rem; text-decoration: none;"><i
                            class="bi bi-envelope-fill"></i> Support</a>
                </div>
                <p style="font-size: 0.7rem; color: #8E7A64; margin-bottom: 8px;">
                    Copyright © 2026 FashionHub. All rights reserved.
                </p>
                <p
                    style="font-size: 0.68rem; color: #9C8A74; max-width: 480px; margin-left: auto; margin-right: auto;">
                    This is a payment confirmation for your recent order. For returns or disputes, please visit our Help
                    Center.
                </p>
                <p style="font-size: 0.6rem; margin-top: 16px;">
                    <a href="#" style="color: #8E7A64;">Privacy Policy</a> | <a href="#"
                        style="color: #8E7A64;">Contact Us</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
