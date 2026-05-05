<x-app>
    @php
        $statusColor = fn ($status) => match ((string) $status) {
            'delivered', 'paid' => 'success',
            'processing', 'confirmed' => 'primary',
            'pending', 'unpaid' => 'warning',
            'failed', 'cancelled', 'refunded' => 'danger',
            default => 'secondary',
        };
    @endphp

    <section class="py-5" style="background:#f7f3ef;min-height:70vh;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">@include('account.partials.sidebar')</div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4 p-lg-5 d-flex flex-wrap justify-content-between gap-3 align-items-center">
                            <div>
                                <h1 class="h3 fw-bold mb-1">Order {{ $order->order_number }}</h1>
                                <p class="text-muted mb-0">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge text-bg-{{ $statusColor($order->order_status->value) }}">{{ ucfirst($order->order_status->value) }}</span>
                                <span class="badge text-bg-{{ $statusColor($order->payment_status->value) }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status->value)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h5 mb-4">Order Items</h2>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead><tr><th>Product</th><th>Qty</th><th>Total</th><th></th></tr></thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                                    @if ($item->variant_label)
                                                        <div class="text-muted small">{{ $item->variant_label }}</div>
                                                    @endif
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format((float) $item->line_total, 2) }}</td>
                                                <td class="text-end">
                                                    @if ($item->product)
                                                        <a href="{{ route('product.details', $item->product->slug) }}" class="btn btn-sm btn-outline-dark">View product</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><h2 class="h5 mb-3">Billing Address</h2><p class="mb-1">{{ $order->customer_name }}</p><p class="mb-1">{{ $order->street_address }}{{ $order->apartment ? ', '.$order->apartment : '' }}</p><p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p><p class="mb-1">{{ $order->country }}</p><p class="text-muted mb-0">{{ $order->customer_email }} | {{ $order->customer_phone }}</p></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><h2 class="h5 mb-3">Order Summary</h2><div class="d-flex justify-content-between mb-2"><span class="text-muted">Subtotal</span><strong>${{ number_format((float) $order->subtotal, 2) }}</strong></div><div class="d-flex justify-content-between mb-2"><span class="text-muted">Shipping</span><strong>${{ number_format((float) $order->shipping_amount, 2) }}</strong></div><div class="d-flex justify-content-between mb-2"><span class="text-muted">Tax</span><strong>${{ number_format((float) $order->tax_amount, 2) }}</strong></div><div class="d-flex justify-content-between mb-2"><span class="text-muted">Discount</span><strong>- ${{ number_format((float) $order->discount_amount, 2) }}</strong></div><hr><div class="d-flex justify-content-between"><span class="fw-semibold">Total</span><strong>${{ number_format((float) $order->total_amount, 2) }}</strong></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
