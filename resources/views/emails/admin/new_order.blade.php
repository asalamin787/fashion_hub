<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FashionHub Admin · New Order Confirmation</title>
    <!-- Bootstrap 5 + Icons + Google Fonts -->
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
            background-color: #EFF2F5;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 32px 16px;
        }

        .admin-email {
            max-width: 680px;
            margin: 0 auto;
            background: #FFFFFF;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.04);
        }

        /* Header - Admin specific */
        .admin-header {
            background: #0F2B3D;
            padding: 28px 36px 24px 36px;
            text-align: left;
            border-bottom: 3px solid #D4B88C;
        }

        .admin-badge {
            background: rgba(212, 184, 140, 0.15);
            padding: 5px 14px;
            display: inline-block;
            border: 0.5px solid rgba(212, 184, 140, 0.4);
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: #D4B88C;
            margin-bottom: 14px;
        }

        .admin-header h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: -0.3px;
            color: #FFFFFF;
            margin: 0 0 4px 0;
        }

        .admin-sub {
            color: #B8D0E0;
            font-size: 0.75rem;
            margin-top: 6px;
        }

        .divider-light {
            height: 2px;
            background-color: #D4B88C;
            width: 45px;
            margin: 16px 0 12px 0;
        }

        .alert-order {
            background: #FFF8E7;
            border-left: 4px solid #D4B88C;
            padding: 14px 20px;
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            background: #F8FAFE;
            border: 1px solid #E9EDF2;
            padding: 20px 24px;
        }

        .info-item {
            flex: 1;
            min-width: 160px;
        }

        .info-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            color: #5B6E8C;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .info-value {
            font-weight: 600;
            color: #1E293B;
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

        .admin-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-admin-primary {
            background: #0F2B3D;
            color: white;
            padding: 10px 24px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
            border: 1px solid #0F2B3D;
        }

        .btn-admin-secondary {
            background: transparent;
            color: #0F2B3D;
            padding: 10px 24px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
            border: 1px solid #C4B5A0;
        }

        footer a {
            text-decoration: none;
            color: #7B6B59;
        }

        @media (max-width: 560px) {
            .admin-header {
                padding: 24px 20px;
                text-align: center;
            }

            .divider-light {
                margin-left: auto;
                margin-right: auto;
            }

            .info-grid {
                flex-direction: column;
                gap: 12px;
            }

            .order-table th,
            .order-table td {
                padding: 8px 6px;
                font-size: 0.7rem;
            }

            body {
                padding: 16px 12px;
            }

            .admin-actions {
                justify-content: center;
            }
        }
    </style>
</head>

<body
    style="background-color: #EFF2F5; font-family: 'Inter', 'Segoe UI', Helvetica, Arial, sans-serif; margin: 0; padding: 32px 16px;">

    <div class="admin-email"
        style="max-width: 680px; margin: 0 auto; background: #FFFFFF; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.03);">

        <!-- ========= ADMIN HEADER ========= -->
        <div class="admin-header" style="background: #0F2B3D; padding: 28px 36px 24px 36px;">
            <div class="admin-badge"
                style="background: rgba(212, 184, 140, 0.15); padding: 4px 14px; display: inline-block;">
                <span style="font-size: 0.65rem; letter-spacing: 1.5px; color: #D4B88C;">🔔 NEW ORDER ALERT</span>
            </div>
            <h1
                style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.8rem; color: #FFFFFF; margin: 8px 0 4px;">
                FashionHub</h1>
            <div class="admin-sub" style="color: #B8D0E0; font-size: 0.75rem;">Administrator · Order Management System
            </div>
            <div class="divider-light" style="height: 2px; background: #D4B88C; width: 45px; margin: 16px 0 12px 0;">
            </div>
            <div class="alert-order"
                style="background: #FFF8E7; border-left: 4px solid #D4B88C; padding: 12px 18px; margin-top: 8px;">
                <span style="font-weight: 700; color: #8A6E3E;">📦 A new order has been placed and requires your
                    attention.</span>
                <span style="font-size: 0.75rem; color: #6B5A4A; display: block; margin-top: 4px;">Order #FH-4289-7XM ·
                    Customer: Alex Morgan</span>
            </div>
        </div>

        <!-- Order Summary for Admin -->
        <div style="padding: 26px 32px 16px 32px; background: white;">
            <div
                style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <p style="margin: 0; font-size: 0.7rem; color: #7E6E5D;">ORDER NUMBER</p>
                    <p style="font-weight: 800; font-size: 1.1rem; margin: 0; letter-spacing: 0.3px;">#FH-4289-7XM</p>
                </div>
                <div style="background: #FFF3E0; padding: 5px 16px; border: 1px solid #FFE0B2;">
                    <span style="font-weight: 600; color: #E65100; font-size: 0.7rem;"><i class="bi bi-clock"></i>
                        PENDING PROCESSING</span>
                </div>
            </div>

            <!-- Quick Stats Grid -->
            <div class="info-grid"
                style="display: flex; flex-wrap: wrap; gap: 20px; background: #F8FAFE; border: 1px solid #E9EDF2; padding: 20px 24px; margin-bottom: 20px;">
                <div class="info-item" style="flex: 1; min-width: 140px;">
                    <div class="info-label" style="font-size: 0.65rem; text-transform: uppercase; color: #5B6E8C;">Order
                        Date</div>
                    <div class="info-value" style="font-weight: 600;">May 4, 2026 · 11:42 AM EST</div>
                </div>
                <div class="info-item" style="flex: 1; min-width: 140px;">
                    <div class="info-label" style="font-size: 0.65rem; text-transform: uppercase; color: #5B6E8C;">Total
                        Amount</div>
                    <div class="info-value" style="font-weight: 800; font-size: 1.2rem; color: #1A4D3A;">$784.75</div>
                </div>
                <div class="info-item" style="flex: 1; min-width: 140px;">
                    <div class="info-label" style="font-size: 0.65rem; text-transform: uppercase; color: #5B6E8C;">
                        Payment Method</div>
                    <div class="info-value">Visa ···· 4242</div>
                </div>
            </div>
        </div>

        <!-- Customer Information Section -->
        <div style="padding: 0px 32px 12px 32px;">
            <h3
                style="font-weight: 700; font-size: 0.9rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                CUSTOMER INFORMATION</h3>
            <div
                style="display: flex; flex-wrap: wrap; gap: 24px; background: #FCFAF5; border: 1px solid #EFE9E1; padding: 18px 24px;">
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D;">CUSTOMER NAME</p>
                    <p style="font-weight: 600; margin: 0;">Alex Morgan</p>
                    <p style="margin: 8px 0 0 0; font-size: 0.75rem; color: #6B5A4A;">alex.morgan@fashionhub.com</p>
                    <p style="margin: 4px 0 0; font-size: 0.75rem; color: #6B5A4A;">+1 (212) 555 1234</p>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D;">BILLING ADDRESS</p>
                    <p style="margin: 0; font-size: 0.8rem; line-height: 1.4;">
                        450 Fifth Avenue, Suite 4<br>
                        New York, NY 10018<br>
                        United States
                    </p>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D;">SHIPPING ADDRESS</p>
                    <p style="margin: 0; font-size: 0.8rem; line-height: 1.4;">
                        450 Fifth Avenue, Suite 4<br>
                        New York, NY 10018<br>
                        United States
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items Table (Admin View) -->
        <div style="padding: 20px 32px 12px 32px;">
            <h3
                style="font-weight: 700; font-size: 0.9rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                ORDER ITEMS</h3>
            <div style="overflow-x: auto;">
                <table class="order-table" style="width: 100%; border-collapse: collapse; border: 1px solid #EDE7DF;">
                    <thead>
                        <tr style="background-color: #FCF9F4;">
                            <th style="padding: 12px 12px;">SKU</th>
                            <th style="padding: 12px 12px;">Item</th>
                            <th style="padding: 12px 12px; text-align: center;">Qty</th>
                            <th style="padding: 12px 12px; text-align: right;">Unit Price</th>
                            <th style="padding: 12px 12px; text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 12px 12px; font-size: 0.7rem;">FH-CM-001</td>
                            <td style="padding: 12px 12px;">
                                <strong>Cashmere Blend Wrap Coat</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Camel · Size M</div>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">$289.00</td>
                            <td style="text-align: right;">$289.00</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 12px; font-size: 0.7rem;">FH-LB-042</td>
                            <td style="padding: 12px 12px;">
                                <strong>Leather Stiletto Boots</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Black · Size 38 EU</div>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">$179.00</td>
                            <td style="text-align: right;">$179.00</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 12px; font-size: 0.7rem;">FH-SD-089</td>
                            <td style="padding: 12px 12px;">
                                <strong>Silk Satin Slip Dress</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Champagne · Size S</div>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">$149.00</td>
                            <td style="text-align: right;">$149.00</td>
                        </tr>
                        <tr style="border-bottom: none;">
                            <td style="padding: 12px 12px; font-size: 0.7rem;">FH-HE-023</td>
                            <td style="padding: 12px 12px;">
                                <strong>Gold-Toned Hoop Earrings</strong>
                                <div style="font-size: 0.65rem; color: #8B7A68;">Limited Edition</div>
                            </td>
                            <td style="text-align: center;">2</td>
                            <td style="text-align: right;">$49.00</td>
                            <td style="text-align: right;">$98.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Totals Breakdown -->
            <div style="margin-top: 20px; background: #FEFCF8; border: 1px solid #E9E2D6; padding: 16px 24px;">
                <div style="display: flex; justify-content: flex-end;">
                    <div style="min-width: 240px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #6F5E4D;">Subtotal</span>
                            <strong>$715.00</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #6F5E4D;">Shipping (Express)</span>
                            <strong>$15.00</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #6F5E4D;">Tax (7.5%)</span>
                            <strong>$54.75</strong>
                        </div>
                        <div style="height: 1px; background: #E1D8CD; margin: 10px 0 12px;"></div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-weight: 800; font-size: 1rem;">GRAND TOTAL</span>
                            <span style="font-size: 1.3rem; font-weight: 800; color: #1A4D3A;">$784.75</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment & Fraud Check Info -->
        <div style="padding: 8px 32px 12px 32px;">
            <div
                style="display: flex; flex-wrap: wrap; gap: 16px; background: #F5F7FC; padding: 16px 20px; border: 1px solid #E9EDF2;">
                <div style="flex: 1;">
                    <i class="bi bi-credit-card-2-front" style="color: #D4B88C;"></i>
                    <span style="font-size: 0.7rem; font-weight: 600; margin-left: 6px;">PAYMENT STATUS</span>
                    <p style="margin: 6px 0 0; font-size: 0.75rem; color: #2E7D32;">✓ Payment captured · Verified</p>
                </div>
                <div style="flex: 1;">
                    <i class="bi bi-shield-check" style="color: #D4B88C;"></i>
                    <span style="font-size: 0.7rem; font-weight: 600; margin-left: 6px;">FRAUD SCORE</span>
                    <p style="margin: 6px 0 0; font-size: 0.75rem;">Low risk · AVS matched</p>
                </div>
                <div style="flex: 1;">
                    <i class="bi bi-envelope-paper" style="color: #D4B88C;"></i>
                    <span style="font-size: 0.7rem; font-weight: 600; margin-left: 6px;">CUSTOMER NOTIFIED</span>
                    <p style="margin: 6px 0 0; font-size: 0.75rem;">Order confirmation sent</p>
                </div>
            </div>
        </div>

        <!-- Admin Actions Panel -->
        <div style="padding: 20px 32px 16px 32px;">
            <h3
                style="font-weight: 700; font-size: 0.9rem; margin-bottom: 14px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                ADMIN ACTIONS</h3>
            <div class="admin-actions" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="#" class="btn-admin-primary"
                    style="background: #0F2B3D; color: white; padding: 10px 24px; text-decoration: none; font-weight: 600; display: inline-block;">📋
                    VIEW ORDER IN ADMIN</a>
                <a href="#" class="btn-admin-secondary"
                    style="background: transparent; color: #0F2B3D; padding: 10px 24px; text-decoration: none; font-weight: 600; display: inline-block; border: 1px solid #C4B5A0;">✏️
                    UPDATE STATUS</a>
                <a href="#" class="btn-admin-secondary"
                    style="background: transparent; color: #0F2B3D; padding: 10px 24px; text-decoration: none; font-weight: 600; display: inline-block; border: 1px solid #C4B5A0;">🖨️
                    PRINT INVOICE</a>
            </div>
        </div>

        <!-- Inventory / Fulfillment Note -->
        <div style="padding: 8px 32px 16px 32px;">
            <div
                style="background: #E8F0FE; padding: 14px 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; border: 1px solid #D0E0F0;">
                <i class="bi bi-box-seam" style="color: #D4B88C; font-size: 1.2rem;"></i>
                <span style="font-size: 0.75rem; color: #3A5A7A;">All items are in stock. Please process this order
                    within 24 hours. Priority shipping selected.</span>
            </div>
        </div>

        <!-- ========= FOOTER ========= -->
        <div style="background: #FFFFFF; padding: 24px 32px 28px 32px; border-top: 1px solid #EDE6DF;">
            <div style="text-align: center;">
                <p style="font-size: 0.7rem; color: #8E7A64; margin-bottom: 8px;">
                    FashionHub · Admin Notification System
                </p>
                <p
                    style="font-size: 0.68rem; color: #9C8A74; max-width: 480px; margin-left: auto; margin-right: auto;">
                    This is an automated message sent to store administrators. Please do not reply to this email.
                </p>
                <p style="font-size: 0.6rem; margin-top: 12px;">
                    <a href="#" style="color: #8E7A64;">Admin Dashboard</a> | <a href="#"
                        style="color: #8E7A64;">Order Settings</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
