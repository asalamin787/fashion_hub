<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class InvoicePrintController extends Controller
{
    public function __invoke(Order $order)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $order->load(['items.product', 'payments']);

        return view('filament.resources.orders.pages.invoice-print', [
            'order' => $order,
            'companyName' => config('app.name', 'Fashion Hub'),
            'companyEmail' => config('mail.from.address', 'hello@example.com'),
        ]);
    }
}
