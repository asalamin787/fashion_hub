<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FashionHub · Order Delivered | Enjoy Your Style</title>
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

        /* Header section - delivered theme (celebration) */
        .header-delivered {
            background: #1A3A2A;
            padding: 36px 38px 30px 38px;
            text-align: left;
            border-bottom: 1px solid #2A5540;
        }

        .delivered-badge {
            background: rgba(76, 175, 80, 0.15);
            padding: 5px 16px;
            display: inline-block;
            border: 0.5px solid rgba(76, 175, 80, 0.4);
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: #A5D6A7;
            margin-bottom: 18px;
        }

        .header-delivered h1 {
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

        .delivered-icon {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(76, 175, 80, 0.08);
            padding: 8px 20px;
            margin-top: 8px;
        }

        .btn-review {
            background-color: #FFFFFF;
            color: #1A3A2A;
            font-weight: 700;
            padding: 12px 32px;
            text-decoration: none;
            display: inline-block;
            border: 1px solid #D4B88C;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .btn-review:hover {
            background-color: #D4B88C;
            color: #1A3A2A;
            border-color: #D4B88C;
        }

        .delivery-card {
            background: #F8FAFE;
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

        .feedback-stars {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 16px 0;
        }

        .star-icon {
            font-size: 1.5rem;
            color: #D4B88C;
            cursor: pointer;
        }

        footer a {
            text-decoration: none;
            color: #7B6B59;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 560px) {
            .header-delivered {
                padding: 28px 24px;
                text-align: center;
            }

            .divider-gold {
                margin-left: auto;
                margin-right: auto;
            }

            .delivered-icon {
                justify-content: center;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
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

        <!-- ========= HEADER: DELIVERED CONFIRMATION SECTION ========= -->
        <div class="header-delivered" style="background: #1A3A2A; padding: 36px 38px 30px 38px;">
            <div class="delivered-badge"
                style="background: rgba(76, 175, 80, 0.15); padding: 5px 16px; display: inline-block; border: 0.5px solid rgba(76,175,80,0.4);">
                <span style="font-size: 0.65rem; letter-spacing: 1.5px; color: #A5D6A7;">✓ ORDER DELIVERED</span>
            </div>
            <h1
                style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 2.2rem; letter-spacing: -0.5px; color: #F1E6D2; margin: 12px 0 4px;">
                FashionHub</h1>
            <div class="header-tagline"
                style="color: #D4B88C; font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 6px;">DELIVERY
                CONFIRMATION</div>
            <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 50px; margin: 16px 0 14px 0;">
            </div>
            <div class="delivered-icon"
                style="display: inline-flex; align-items: center; gap: 8px; background: rgba(76,175,80,0.08); padding: 8px 18px; margin-top: 8px;">
                <i class="bi bi-check2-circle" style="color: #A5D6A7; font-size: 1rem;"></i>
                <span style="color: #EADBC8; font-size: 0.8rem; font-weight: 500;">Your order has been delivered!</span>
            </div>
        </div>

        <!-- Delivery confirmation message & details -->
        <div style="padding: 26px 32px 16px 32px; background: white;">
            <div
                style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <p style="margin: 0; font-size: 0.7rem; color: #7E6E5D;">ORDER NUMBER</p>
                    <p style="font-weight: 800; font-size: 0.95rem; margin: 0; letter-spacing: 0.3px;">#FH-4289-7XM</p>
                </div>
                <div style="background: #E8F5E9; padding: 5px 16px; border: 1px solid #C8E6C9;">
                    <span style="font-weight: 600; color: #2E7D32; font-size: 0.7rem;"><i class="bi bi-check2-all"></i>
                        DELIVERED</span>
                </div>
            </div>

            <!-- Delivery message -->
            <div style="margin: 8px 0 18px 0; background: #F5F9F5; padding: 20px 24px; border: 1px solid #DEEADE;">
                <h2 style="font-weight: 700; font-size: 1.3rem; margin: 0 0 8px 0; color: #232120;">Package delivered
                    successfully!</h2>
                <p style="margin-bottom: 6px; font-size: 0.9rem; color: #4C4238;">Your order
                    <strong>#FH-4289-7XM</strong> was delivered on <strong>May 7, 2026</strong> at 03:15 PM EST.</p>
                <div class="divider-gold" style="height: 2px; background: #D4B88C; width: 45px; margin: 16px 0 12px 0;">
                </div>
                <p style="font-size: 0.8rem; color: #5D6E5F;">Your package was left at the front door. A delivery
                    confirmation has been sent to <strong>alex.morgan@fashionhub.com</strong>.</p>
            </div>

            <!-- Review Button -->
            <div style="margin: 6px 0 8px 0;">
                <a href="#" class="btn-review"
                    style="background: white; color: #1A3A2A; border: 1.5px solid #D4B88C; padding: 11px 34px; font-weight: 600; text-decoration: none; display: inline-block;">★
                    LEAVE A REVIEW</a>
            </div>
        </div>

        <!-- ========= DELIVERY INFORMATION SECTION ========= -->
        <div style="padding: 12px 32px 8px 32px;">
            <h3
                style="font-weight: 600; font-size: 1rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                DELIVERY DETAILS</h3>
            <div class="delivery-card" style="background: #F8FAFE; border: 1px solid #E9EDF2; padding: 20px 24px;">
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Carrier</span>
                    <span><strong>DHL Express Worldwide</strong></span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Tracking Number</span>
                    <span><strong>DHL-9876-5432-1098</strong></span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Delivery Date</span>
                    <span style="color: #2E7D32; font-weight: 600;">May 7, 2026 · 03:15 PM EST</span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #EEF2F8;">
                    <span style="color: #5B6E8C;">Delivery Location</span>
                    <span>Front Door · No signature required</span>
                </div>
                <div class="info-row" style="display: flex; justify-content: space-between; padding: 10px 0;">
                    <span style="color: #5B6E8C;">Proof of Delivery</span>
                    <span><a href="#" style="color: #A67C4A;">View delivery confirmation →</a></span>
                </div>
            </div>
        </div>

        <!-- ========= DELIVERED ORDER SUMMARY (items) ========= -->
        <div style="padding: 20px 32px 12px 32px;">
            <h3
                style="font-weight: 600; font-size: 1rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                DELIVERED ITEMS</h3>
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

            <!-- Delivery address -->
            <div style="margin-top: 20px; background: #FEFCF8; border: 1px solid #E9E2D6; padding: 16px 24px;">
                <p style="margin: 0 0 8px 0; font-size: 0.7rem; color: #7E6E5D; letter-spacing: 0.5px;">DELIVERY ADDRESS
                </p>
                <p style="margin: 0; font-size: 0.85rem; line-height: 1.4;">
                    Alex Morgan<br>
                    450 Fifth Avenue, Suite 4<br>
                    New York, NY 10018<br>
                    United States
                </p>
            </div>
        </div>

        <!-- ========= REQUEST REVIEW / FEEDBACK SECTION ========= -->
        <div style="padding: 16px 32px 12px 32px;">
            <div style="background: #F9F6F0; border: 1px solid #EFE9E1; padding: 24px 24px; text-align: center;">
                <i class="bi bi-star-fill" style="color: #D4B88C; font-size: 2rem;"></i>
                <h3 style="font-weight: 700; margin: 12px 0 8px 0; color: #2F2A24;">Love your new pieces?</h3>
                <p style="font-size: 0.85rem; color: #5D6E5F; margin-bottom: 16px;">Share your style with the
                    FashionHub community and earn rewards on your next purchase.</p>
                <div class="feedback-stars"
                    style="display: flex; gap: 8px; justify-content: center; margin: 0 0 16px 0;">
                    <i class="bi bi-star-fill star-icon" style="font-size: 1.5rem; color: #D4B88C;"></i>
                    <i class="bi bi-star-fill star-icon" style="font-size: 1.5rem; color: #D4B88C;"></i>
                    <i class="bi bi-star-fill star-icon" style="font-size: 1.5rem; color: #D4B88C;"></i>
                    <i class="bi bi-star-fill star-icon" style="font-size: 1.5rem; color: #D4B88C;"></i>
                    <i class="bi bi-star-fill star-icon" style="font-size: 1.5rem; color: #D4B88C;"></i>
                </div>
                <a href="#"
                    style="background: #1A3A2A; color: white; padding: 10px 28px; text-decoration: none; display: inline-block; font-weight: 600; font-size: 0.8rem;">WRITE
                    A REVIEW</a>
            </div>
        </div>

        <!-- What's Next section -->
        <div style="padding: 8px 32px 12px 32px;">
            <div
                style="background: #E8F0FE; padding: 16px 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; border: 1px solid #D0E0F0;">
                <i class="bi bi-arrow-return-left" style="color: #D4B88C; font-size: 1.1rem;"></i>
                <span style="font-size: 0.75rem; color: #3A5A7A;">Not satisfied? You have until <strong>June 6,
                        2026</strong> to initiate a return or exchange. Visit our <a href="#"
                        style="color: #A67C4A;">Returns Center</a>.</span>
            </div>
        </div>

        <!-- ========= SUPPORT SECTION ========= -->
        <div style="padding: 14px 32px 20px 32px;">
            <div style="background: #F9F6F0; border-left: 4px solid #C4A06A; padding: 20px 26px;">
                <h4 style="font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><i
                        class="bi bi-chat-heart-fill"></i> Enjoy your purchase?</h4>
                <p style="margin-bottom: 8px; font-size: 0.85rem;">If you have any questions about your delivered
                    items, need styling advice, or want to start a return, our team is here to help.</p>
                <p style="margin: 0; font-size: 0.8rem;">
                    📧 <a href="mailto:care@fashionhub.com"
                        style="color: #A67C4A; text-decoration: underline;">care@fashionhub.com</a> &nbsp;|&nbsp; 📞 +1
                    (212) 555 8273
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
                            class="bi bi-tiktok"></i> TikTok</a>
                </div>
                <p style="font-size: 0.7rem; color: #8E7A64; margin-bottom: 8px;">
                    Copyright © 2026 FashionHub. All rights reserved.
                </p>
                <p
                    style="font-size: 0.68rem; color: #9C8A74; max-width: 480px; margin-left: auto; margin-right: auto;">
                    This is a delivery confirmation for your recent order. If you did not receive your package, please
                    contact us immediately.
                </p>
                <p style="font-size: 0.6rem; margin-top: 14px;">
                    <a href="#" style="color: #8E7A64;">Privacy Policy</a> | <a href="#"
                        style="color: #8E7A64;">Return Policy</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
