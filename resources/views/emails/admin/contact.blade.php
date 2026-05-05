<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FashionHub Admin · New Contact Form Submission</title>
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
            max-width: 660px;
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

        .alert-contact {
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

        .message-box {
            background: #FCFAF5;
            border: 1px solid #EFE9E1;
            padding: 20px 24px;
            margin-top: 8px;
        }

        .message-content {
            font-size: 0.9rem;
            line-height: 1.5;
            color: #2F2A24;
            white-space: pre-wrap;
            background: #FFFFFF;
            padding: 16px;
            border: 1px solid #EDE6DF;
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
            transition: 0.2s;
        }

        .btn-admin-primary:hover {
            background: #1A4058;
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

        .btn-admin-secondary:hover {
            background: #F5F0EA;
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
        style="max-width: 660px; margin: 0 auto; background: #FFFFFF; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.03);">

        <!-- ========= ADMIN HEADER ========= -->
        <div class="admin-header" style="background: #0F2B3D; padding: 28px 36px 24px 36px;">
            <div class="admin-badge"
                style="background: rgba(212, 184, 140, 0.15); padding: 5px 14px; display: inline-block;">
                <span style="font-size: 0.65rem; letter-spacing: 1.5px; color: #D4B88C;">✉️ NEW CONTACT FORM
                    SUBMISSION</span>
            </div>
            <h1
                style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.8rem; color: #FFFFFF; margin: 8px 0 4px;">
                FashionHub</h1>
            <div class="admin-sub" style="color: #B8D0E0; font-size: 0.75rem;">Administrator · Customer Support System
            </div>
            <div class="divider-light" style="height: 2px; background: #D4B88C; width: 45px; margin: 16px 0 12px 0;">
            </div>
            <div class="alert-contact"
                style="background: #FFF8E7; border-left: 4px solid #D4B88C; padding: 12px 18px; margin-top: 8px;">
                <span style="font-weight: 700; color: #8A6E3E;"><i class="bi bi-chat-dots-fill"></i> A customer has
                    submitted a support inquiry.</span>
                <span style="font-size: 0.75rem; color: #6B5A4A; display: block; margin-top: 4px;">From: Alex Morgan ·
                    Subject: Order #FH-4289-7XM status</span>
            </div>
        </div>

        <!-- Contact Submission Summary -->
        <div style="padding: 26px 32px 16px 32px; background: white;">
            <div
                style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <p style="margin: 0; font-size: 0.7rem; color: #7E6E5D;">SUBMISSION ID</p>
                    <p style="font-weight: 800; font-size: 0.95rem; margin: 0; letter-spacing: 0.3px;">
                        #CT-2026-05-05-001</p>
                </div>
                <div style="background: #FFF3E0; padding: 5px 16px; border: 1px solid #FFE0B2;">
                    <span style="font-weight: 600; color: #E65100; font-size: 0.7rem;"><i class="bi bi-clock"></i>
                        PENDING RESPONSE</span>
                </div>
            </div>

            <!-- Quick Stats Grid -->
            <div class="info-grid"
                style="display: flex; flex-wrap: wrap; gap: 20px; background: #F8FAFE; border: 1px solid #E9EDF2; padding: 20px 24px; margin-bottom: 20px;">
                <div class="info-item" style="flex: 1; min-width: 140px;">
                    <div class="info-label" style="font-size: 0.65rem; text-transform: uppercase; color: #5B6E8C;">
                        Submitted On</div>
                    <div class="info-value" style="font-weight: 600;">May 5, 2026 · 09:47 AM EST</div>
                </div>
                <div class="info-item" style="flex: 1; min-width: 140px;">
                    <div class="info-label" style="font-size: 0.65rem; text-transform: uppercase; color: #5B6E8C;">
                        Priority</div>
                    <div class="info-value" style="color: #E65100; font-weight: 700;">Medium Priority</div>
                </div>
                <div class="info-item" style="flex: 1; min-width: 140px;">
                    <div class="info-label" style="font-size: 0.65rem; text-transform: uppercase; color: #5B6E8C;">
                        Channel</div>
                    <div class="info-value">Website Contact Form</div>
                </div>
            </div>
        </div>

        <!-- Customer Information Section -->
        <div style="padding: 0px 32px 12px 32px;">
            <h3
                style="font-weight: 700; font-size: 0.9rem; margin-bottom: 16px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                CUSTOMER DETAILS</h3>
            <div
                style="display: flex; flex-wrap: wrap; gap: 24px; background: #FCFAF5; border: 1px solid #EFE9E1; padding: 18px 24px;">
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D;">FULL NAME</p>
                    <p style="font-weight: 600; margin: 0;">Alex Morgan</p>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D;">EMAIL ADDRESS</p>
                    <p style="margin: 0;"><a href="mailto:alex.morgan@fashionhub.com"
                            style="color: #A67C4A; text-decoration: underline;">alex.morgan@fashionhub.com</a></p>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #7E6E5D;">PHONE NUMBER</p>
                    <p style="margin: 0;">+1 (212) 555 1234</p>
                </div>
            </div>
        </div>

        <!-- Message Subject -->
        <div style="padding: 12px 32px 8px 32px;">
            <div style="background: #FCFAF5; border: 1px solid #EFE9E1; padding: 14px 20px;">
                <div class="info-label" style="font-size: 0.7rem; margin-bottom: 6px;">SUBJECT</div>
                <div class="info-value" style="font-weight: 700; font-size: 1rem;">Question about order status and
                    delivery timeline</div>
            </div>
        </div>

        <!-- Message Content (Main Inquiry) -->
        <div style="padding: 8px 32px 16px 32px;">
            <div class="message-box" style="background: #FCFAF5; border: 1px solid #EFE9E1; padding: 20px 24px;">
                <div class="info-label" style="font-size: 0.7rem; margin-bottom: 10px;">MESSAGE CONTENT</div>
                <div class="message-content"
                    style="font-size: 0.9rem; line-height: 1.5; color: #2F2A24; background: #FFFFFF; padding: 18px; border: 1px solid #EDE6DF;">
                    Hello FashionHub team,<br><br>
                    I placed an order on May 4th (Order #FH-4289-7XM) and the tracking information hasn't been updated
                    for the past 48 hours.<br><br>
                    Could you please check the status of my shipment? I need the items for an event on May 10th. Also,
                    is it possible to upgrade the shipping if it's delayed?<br><br>
                    Thank you for your help.<br><br>
                    Best regards,<br>
                    Alex Morgan
                </div>
            </div>
        </div>

        <!-- Additional Context (Order Reference) -->
        <div style="padding: 8px 32px 12px 32px;">
            <div style="background: #F5F7FC; border: 1px solid #E9EDF2; padding: 16px 20px;">
                <div style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.7rem; color: #5B6E8C;">REFERENCED ORDER</span>
                        <p style="font-weight: 700; margin: 4px 0 0;">#FH-4289-7XM</p>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: #5B6E8C;">ORDER TOTAL</span>
                        <p style="font-weight: 700; margin: 4px 0 0;">$784.75</p>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: #5B6E8C;">ORDER DATE</span>
                        <p style="font-weight: 700; margin: 4px 0 0;">May 4, 2026</p>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: #5B6E8C;">CURRENT STATUS</span>
                        <p style="margin: 4px 0 0; color: #E65100; font-weight: 600;">Shipped · In Transit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions Panel (Response Options) -->
        <div style="padding: 20px 32px 16px 32px;">
            <h3
                style="font-weight: 700; font-size: 0.9rem; margin-bottom: 14px; color: #2F2A24; border-left: 4px solid #D4B88C; padding-left: 14px;">
                ADMIN RESPONSE ACTIONS</h3>
            <div class="admin-actions" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="#" class="btn-admin-primary"
                    style="background: #0F2B3D; color: white; padding: 10px 24px; text-decoration: none; font-weight: 600; display: inline-block;">✉️
                    REPLY TO CUSTOMER</a>
                <a href="#" class="btn-admin-secondary"
                    style="background: transparent; color: #0F2B3D; padding: 10px 24px; text-decoration: none; font-weight: 600; display: inline-block; border: 1px solid #C4B5A0;">📋
                    VIEW IN CRM</a>
                <a href="#" class="btn-admin-secondary"
                    style="background: transparent; color: #0F2B3D; padding: 10px 24px; text-decoration: none; font-weight: 600; display: inline-block; border: 1px solid #C4B5A0;">🏷️
                    MARK AS RESOLVED</a>
            </div>
        </div>

        <!-- Response Guidelines / Quick Tips -->
        <div style="padding: 8px 32px 20px 32px;">
            <div
                style="background: #E8F0FE; padding: 14px 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; border: 1px solid #D0E0F0;">
                <i class="bi bi-lightbulb" style="color: #D4B88C; font-size: 1.2rem;"></i>
                <span style="font-size: 0.75rem; color: #3A5A7A;"><strong>Quick Tip:</strong> Response time goal:
                    within 4 hours. Consider using the order management tool to provide real-time tracking
                    updates.</span>
            </div>
        </div>

        <!-- Support Ticket Info -->
        <div style="padding: 8px 32px 20px 32px;">
            <div style="background: #F9F6F0; border-left: 4px solid #C4A06A; padding: 16px 20px;">
                <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <span style="font-size: 0.65rem; color: #7E6E5D;">TICKET ID</span>
                        <p style="font-weight: 600; margin: 2px 0 0;">TKT-FH-20260505-001</p>
                    </div>
                    <div>
                        <span style="font-size: 0.65rem; color: #7E6E5D;">ASSIGNED TO</span>
                        <p style="font-weight: 600; margin: 2px 0 0;">Unassigned · Support Queue</p>
                    </div>
                    <div>
                        <span style="font-size: 0.65rem; color: #7E6E5D;">CATEGORY</span>
                        <p style="font-weight: 600; margin: 2px 0 0;">Shipping Inquiry</p>
                    </div>
                </div>
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
                    This is an automated message sent to store administrators when a customer submits a contact form.
                    Please do not reply to this email.
                </p>
                <p style="font-size: 0.6rem; margin-top: 12px;">
                    <a href="#" style="color: #8E7A64;">Admin Dashboard</a> | <a href="#"
                        style="color: #8E7A64;">Support Settings</a> | <a href="#"
                        style="color: #8E7A64;">Response Templates</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
