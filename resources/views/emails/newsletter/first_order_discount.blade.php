<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FashionHub</title>
</head>
<body style="margin:0; padding:24px; background:#f8f5f2; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <table role="presentation" style="max-width:620px; width:100%; margin:0 auto; background:#ffffff; border:1px solid #eadfd8; border-collapse:collapse;">
        <tr>
            <td style="padding:28px 30px; background:#111827; color:#f9fafb;">
                <h1 style="margin:0; font-size:28px; line-height:1.2;">You got 15% off your first order</h1>
                <p style="margin:10px 0 0; color:#d1d5db; font-size:14px;">Thanks for subscribing to FashionHub newsletter.</p>
            </td>
        </tr>
        <tr>
            <td style="padding:28px 30px;">
                <p style="margin:0 0 12px; font-size:15px;">Hi {{ $user->name }},</p>
                <p style="margin:0 0 12px; font-size:15px; line-height:1.6;">
                    Your first-order discount is now active. Use your subscribed email at checkout and we will automatically apply <strong>15% off</strong> your first order.
                </p>
                <p style="margin:0 0 20px; font-size:14px; color:#6b7280; line-height:1.6;">
                    No coupon code needed. This offer is tied to your email and can be used only once.
                </p>
                <a href="{{ $shopUrl }}" style="display:inline-block; padding:12px 22px; background:#865749; color:#ffffff; text-decoration:none; font-weight:700;">Shop Now</a>
            </td>
        </tr>
    </table>
</body>
</html>
