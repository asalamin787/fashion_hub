<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FashionHub · Payment Received | Transaction Receipt</title>
    <!-- Bootstrap 5 + Icons + Google Fonts (luxury, minimal, professional) -->
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
            max-width: 660px;
            margin: 0 auto;
            background: #FFFFFF;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.03);
        }

        /* Header section - brand only (elegant) */
        .header-payment {
            background: #0A0A0C;
            padding: 36px 38px 30px 38px;
            text-align: left;
            border-bottom: 1px solid #2A2A2E;
        }

        .payment-badge {
            background: rgba(76, 175, 80, 0.12);
            padding: 5px 16px;
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
            margin-bottom: 16px;
            opacity: 0.85;
        }

        .divider-gold {
            height: 2px;
            background-color: #D4B88C;
            width: 50px;
            margin: 16px 0 16px 0;
        }

        .payment-success-icon {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(76, 175, 80, 0.08);
            padding: 8px 20px;
            margin-top: 8px;
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

        /* Payment Fields Card - detailed breakdown */
        .payment-fields-card {
            background: #F8FAFE;
            border: 1px solid #E9EDF2;
            padding: 0;
            overflow: hidden;
        }

        .field-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 14px 20px;
            border-bottom: 1px solid #E9EDF2;
        }

        .field-row:last-child {
            border-bottom: none;
        }

        .field-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #5B6E8C;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            min-width: 140px;
        }

        .field-value {
            font-weight: 500;
            color: #1E293B;
            text-align: right;
            word-break: break-word;
        }

        .amount-highlight {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1A4D3A;
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

            .field-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .field-value {
                text-align: left;
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
        style="max-width: 660px; margin: 0 auto; background: #FFFFFF; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.03);">

        <!-- ========= HEADER: PAYMENT CONFIRMATION BRAND SECTION ========= -->
        <div class="header-payment" style="background: #0A0A0C; padding: 36px 38px 30px 38px;">
            <div class="payment-badge"
                style="background: rgba(76, 175, 80, 0.12); padding: 5px 16px; display: inline-block; border: 0.5px solid rgba(76,175,80,0.35);">
                <span style="font-size: 0.65rem; letter-spacing: 1.5px; color: #4CAF50;">✓ PAYMENT RECEIVED</span>
            </div>
            <h1
                style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 2.2rem; letter-spacing: -0.5px; color: #F1E6D2; margin: 12px 0 4px;">
                FashionHub</h1>
            <div class="header-tagline"
                style="color: #D4B88C; font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 6px;">PAYMENT CONFIRMATION
                · TRANSACTION RECEIPT</div>
            <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 50px; margin: 16px 0 14px 0;">
            </div>
            <div class="payment-success-icon"
                style="display: inline-flex; align-items: center; gap: 8px; background: rgba(76,175,80,0.08); padding: 8px 18px; margin-top: 8px;">
                <i class="bi bi-check-circle-fill" style="color: #4CAF50; font-size: 1rem;"></i>
                <span style="color: #EADBC8; font-size: 0.8rem; font-weight: 500;">Your payment has been successfully
                    processed</span>
            </div>
        </div>

        <!-- Payment confirmation message & summary -->
        <div style="padding: 26px 32px 16px 32px; background: white;">
            <div
                style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <p style="margin: 0; font-size: 0.7rem; color: #7E6E5D;">TRANSACTION ID</p>
                    <p style="font-weight: 800; font-size: 0.95rem; margin: 0; letter-spacing: 0.3px;">TXN-FH-9X42K-8M3P
                    </p>
                </div>
                <div style="background: #E8F5E9; padding: 5px 16px; border: 1px solid #C8E6C9;">
                    <span style="font-weight: 600; color: #2E7D32; font-size: 0.7rem;"><i
                            class="bi bi-check2-circle"></i> PAID IN FULL</span>
                </div>
            </div>

            <!-- Success message -->
            <div style="margin: 8px 0 18px 0; background: #FCFAF5; padding: 20px 24px; border: 1px solid #EFE9E1;">
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
            <div style="margin: 6px 0 8px 0;">
                <a href="#" class="btn-view-order"
                    style="background: white; color: #1F1C19; border: 1.5px solid #D4B88C; padding: 11px 34px; font-weight: 600; text-decoration: none; display: inline-block;">VIEW
                    ORDER DETAILS →</a>
            </div>
        </div>

        <!-- ========= ENHANCED PAYMENT FIELDS SECTION (detailed breakdown) ========= -->
        <div style="padding: 12px 32px 8px 32px;">
            <h3
                style="font-weight: 600; font-size: 1rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                PAYMENT FIELDS</h3>
            <div class="payment-fields-card" style="background: #F8FAFE; border: 1px solid #E9EDF2;">
                <!-- Field row: Payment Method -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Payment
                        Method</div>
                    <div class="field-value" style="display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-credit-card-2-front"></i> Visa Credit Card ···· 4242
                    </div>
                </div>
                <!-- Field row: Cardholder Name -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Cardholder
                        Name</div>
                    <div class="field-value">ALEX R. MORGAN</div>
                </div>
                <!-- Field row: Transaction Date & Time -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Transaction
                        Date</div>
                    <div class="field-value">May 4, 2026 · 11:42:23 AM EST</div>
                </div>
                <!-- Field row: Authorization Code -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Authorization
                        Code</div>
                    <div class="field-value"><strong>AUTH-87F2-9G4H</strong></div>
                </div>
                <!-- Field row: Transaction ID -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Transaction
                        ID</div>
                    <div class="field-value">TXN-FH-9X42K-8M3P</div>
                </div>
                <!-- Field row: Payment Status -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Payment
                        Status</div>
                    <div class="field-value" style="color: #2E7D32; font-weight: 600;">✓ Captured / Settled</div>
                </div>
                <!-- Field row: Payment Type -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Payment Type
                    </div>
                    <div class="field-value">One-time Payment (Full Amount)</div>
                </div>
                <!-- Field row: Currency & Conversion -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 14px 22px; border-bottom: 1px solid #E9EDF2;">
                    <div class="field-label" style="font-size: 0.75rem; font-weight: 600; color: #5B6E8C;">Currency
                    </div>
                    <div class="field-value">USD · United States Dollar</div>
                </div>
                <!-- Field row: Total Charged (highlight) -->
                <div class="field-row"
                    style="display: flex; justify-content: space-between; padding: 18px 22px; background: #FEFCF8;">
                    <div class="field-label" style="font-size: 0.9rem; font-weight: 800; color: #1E293B;">Total Charged
                    </div>
                    <div class="field-value amount-highlight"
                        style="font-size: 1.5rem; font-weight: 800; color: #1A4D3A;">$784.75</div>
                </div>
            </div>
        </div>

        <!-- ========= ORDER SUMMARY (items purchased) ========= -->
        <div style="padding: 20px 32px 12px 32px;">
            <h3
                style="font-weight: 600; font-size: 1rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                ORDER SUMMARY</h3>
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
                        <div style="font-size: 1.1rem; font-weight: 800;">Total: <span
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

        <!-- Payment security note -->
        <div style="padding: 8px 32px 12px 32px;">
            <div
                style="background: #F1F8F1; padding: 14px 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; border: 1px solid #D4E6D4;">
                <i class="bi bi-shield-lock-fill" style="color: #2E7D32; font-size: 1.1rem;"></i>
                <span style="font-size: 0.75rem; color: #2E4A2E;">Your payment is secured by SSL encryption and PCI-DSS
                    compliance. Transaction reference saved for your records.</span>
            </div>
        </div>

        <!-- ========= SUPPORT SECTION ========= -->
        <div style="padding: 14px 32px 20px 32px;">
            <div style="background: #F9F6F0; border-left: 4px solid #C4A06A; padding: 20px 26px;">
                <h4 style="font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><i
                        class="bi bi-headset"></i> Need help with this payment?</h4>
                <p style="margin-bottom: 8px; font-size: 0.85rem;">If you have any questions about this transaction,
                    refunds, or payment methods, please contact our billing support team.</p>
                <p style="margin: 0; font-size: 0.8rem;">
                    📧 <a href="mailto:billing@fashionhub.com"
                        style="color: #A67C4A; text-decoration: underline;">billing@fashionhub.com</a> &nbsp;|&nbsp; 📞
                    +1 (212) 555 8273
                </p>
            </div>
        </div>

        <!-- ========= FOOTER ========= -->
        <div style="background: #FFFFFF; padding: 24px 32px 32px 32px; border-top: 1px solid #EDE6DF;">
            <div style="text-align: center;">
                <div style="display: flex; justify-content: center; gap: 28px; margin-bottom: 18px; flex-wrap: wrap;">
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
                    This is a payment confirmation receipt for your recent order. Keep this for your records.
                </p>
                <p style="font-size: 0.6rem; margin-top: 14px;">
                    <a href="#" style="color: #8E7A64;">Privacy Policy</a> | <a href="#"
                        style="color: #8E7A64;">Contact Billing</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
