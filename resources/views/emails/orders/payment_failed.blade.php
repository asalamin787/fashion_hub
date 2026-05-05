<x-mail::message>
# Payment Failed

Hi {{ $order->customer_first_name }},

Unfortunately, the payment for your order {{ $order->order_number }} could not be processed.

<x-mail::panel>
Order Number: {{ $order->order_number }}  
Order Total: ${{ number_format((float) $order->total_amount, 2) }}  
Attempt Date: {{ now()->format('d M Y, h:i A') }}  
@if(filled($failureReason))
Reason: {{ $failureReason }}
@else
Reason: The payment could not be completed. Please check your payment details and try again.
@endif
</x-mail::panel>

## What you can do

1. **Try again with the same payment method** - There may have been a temporary issue.
2. **Use a different payment method** - Try another card or payment option.
3. **Contact your bank** - Your bank may have declined the transaction for security reasons.
4. **Contact our support team** - We're here to help if you have any questions.

Your order is currently on hold. To complete your purchase, please retry the payment as soon as possible.

<x-mail::button :url="$orderUrl">
Retry Payment
</x-mail::button>

If you'd prefer to cancel this order and try a different payment method, or if you have any questions, please reach out to us at {{ $supportEmail }} or {{ $supportPhone }}.

We look forward to getting your order shipped out soon!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
