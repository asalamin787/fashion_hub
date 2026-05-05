<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your FashionHub order '.$this->order->order_number.' is confirmed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.success_order',
            with: [
                'order' => $this->order,
                'billingAddress' => $this->order->billingAddress(),
                'shippingAddress' => $this->order->shippingAddress(),
                'supportEmail' => setting('contact.email', config('mail.from.address')),
                'supportPhone' => setting('contact.phone', '+1 (555) 123-4567'),
                'shopUrl' => route('shop'),
                'orderUrl' => $this->order->user_id ? route('account.orders.show', $this->order->order_number) : route('order.confirmation', $this->order->order_number),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
