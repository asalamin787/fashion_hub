<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[New Order] '.$this->order->order_number.' — '.$this->order->customer_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new_order',
            with: [
                'order' => $this->order,
                'billingAddress' => $this->order->billingAddress(),
                'shippingAddress' => $this->order->shippingAddress(),
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
