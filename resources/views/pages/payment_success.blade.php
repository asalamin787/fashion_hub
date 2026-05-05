<x-app>
    <section class="py-5" style="background:linear-gradient(135deg,#f0e4db,#faf6f1);">
        <div class="container py-4">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 align-items-start">
                        <div class="col-lg-8">
                            <span class="badge rounded-pill mb-3" style="background:#e9f7ef;color:#1b7a43;">Order confirmed</span>
                            <h1 class="display-6 fw-bold mb-2">Thank you, {{ $order->customer_first_name }}.</h1>
                            <p class="text-muted mb-4">Your payment was successful and your order is now being prepared for fulfillment.</p>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6 col-xl-3"><div class="rounded-4 p-3 h-100" style="background:#f8f3ef;"><div class="small text-muted mb-1">Order Number</div><div class="fw-bold">{{ $order->order_number }}</div></div></div>
                                <div class="col-md-6 col-xl-3"><div class="rounded-4 p-3 h-100" style="background:#f8f3ef;"><div class="small text-muted mb-1">Payment Status</div><div class="fw-bold text-capitalize">{{ str_replace('_', ' ', $order->payment_status->value) }}</div></div></div>
                                <div class="col-md-6 col-xl-3"><div class="rounded-4 p-3 h-100" style="background:#f8f3ef;"><div class="small text-muted mb-1">Order Status</div><div class="fw-bold text-capitalize">{{ $order->order_status->value }}</div></div></div>
                                <div class="col-md-6 col-xl-3"><div class="rounded-4 p-3 h-100" style="background:#f8f3ef;"><div class="small text-muted mb-1">Order Total</div><div class="fw-bold">${{ number_format((float) $order->total_amount, 2) }}</div></div></div>
                            </div>

                            <div class="card border-0 bg-light-subtle mb-4"><div class="card-body p-4"><h2 class="h5 mb-3">Items ordered</h2><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Item</th><th>Qty</th><th>Total</th></tr></thead><tbody>@foreach ($order->items as $item)<tr><td><div class="fw-semibold">{{ $item->product_name }}</div>@if ($item->variant_label)<div class="small text-muted">{{ $item->variant_label }}</div>@endif</td><td>{{ $item->quantity }}</td><td>${{ number_format((float) $item->line_total, 2) }}</td></tr>@endforeach</tbody></table></div></div></div>

                            <div class="row g-4">
                                <div class="col-md-6"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><h2 class="h5 mb-3">Billing Address</h2><p class="mb-1">{{ $order->customer_name }}</p><p class="mb-1">{{ $order->street_address }}{{ $order->apartment ? ', '.$order->apartment : '' }}</p><p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p><p class="mb-1">{{ $order->country }}</p><p class="text-muted mb-0">{{ $order->customer_email }} | {{ $order->customer_phone }}</p></div></div></div>
                                <div class="col-md-6"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><h2 class="h5 mb-3">Shipping Address</h2><p class="mb-1">{{ $order->shippingAddress()['name'] }}</p><p class="mb-1">{{ $order->shippingAddress()['line_1'] }}{{ $order->shippingAddress()['line_2'] ? ', '.$order->shippingAddress()['line_2'] : '' }}</p><p class="mb-1">{{ $order->shippingAddress()['city'] }}, {{ $order->shippingAddress()['state'] }} {{ $order->shippingAddress()['postal_code'] }}</p><p class="mb-1">{{ $order->shippingAddress()['country'] }}</p><p class="text-muted mb-0">{{ $order->shippingAddress()['phone'] }}</p></div></div></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm"><div class="card-body p-4"><h2 class="h5 mb-3">Order Summary</h2><div class="d-flex justify-content-between mb-2"><span class="text-muted">Subtotal</span><strong>${{ number_format((float) $order->subtotal, 2) }}</strong></div><div class="d-flex justify-content-between mb-2"><span class="text-muted">Shipping</span><strong>${{ number_format((float) $order->shipping_amount, 2) }}</strong></div><div class="d-flex justify-content-between mb-2"><span class="text-muted">Tax</span><strong>${{ number_format((float) $order->tax_amount, 2) }}</strong></div><div class="d-flex justify-content-between mb-3"><span class="text-muted">Discount</span><strong>- ${{ number_format((float) $order->discount_amount, 2) }}</strong></div><hr><div class="d-flex justify-content-between"><span class="fw-semibold">Total</span><strong>${{ number_format((float) $order->total_amount, 2) }}</strong></div><div class="d-grid gap-2 mt-4"><a href="{{ auth()->check() ? route('account.orders.show', $order->order_number) : route('order.confirmation', $order->order_number) }}" class="btn btn-dark rounded-pill">View Order</a><a href="{{ route('shop') }}" class="btn btn-outline-dark rounded-pill">Continue Shopping</a></div><p class="small text-muted mt-3 mb-0">A confirmation email has been sent to {{ $order->customer_email }}.</p></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
