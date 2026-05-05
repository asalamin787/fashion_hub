<x-app>
    <section class="page-header">
        <div class="container">
            <h1>Order Confirmed</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Order Confirmed</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="text-center mb-5">
                        <div style="font-size: 4rem; color: #28a745;">&#10003;</div>
                        <h2 class="mt-3">Thank You for Your Order!</h2>
                        <p class="text-muted">
                            Your order has been placed successfully. We will process it shortly.
                        </p>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Order Number</small>
                                    <strong class="fs-5">{{ $order->order_number }}</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Date</small>
                                    <strong>{{ $order->placed_at?->format('d M Y, H:i') ?? $order->created_at->format('d M Y, H:i') }}</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Payment</small>
                                    <strong>{{ ucwords(str_replace('_', ' ', $order->payment_method->value)) }}</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-warning text-dark">{{ ucfirst($order->order_status->value) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <strong>Items Ordered</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        @php
                                            $itemImage = $item->image && ! str_starts_with($item->image, 'http')
                                                ? asset('storage/' . ltrim($item->image, '/'))
                                                : $item->image;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($itemImage)
                                                        <img src="{{ $itemImage }}"
                                                             alt="{{ $item->product_name }}"
                                                             style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->product_name }}</div>
                                                        @if ($item->variant_label)
                                                            <small class="text-muted">{{ $item->variant_label }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format((float) $item->unit_price, 2) }}</td>
                                            <td class="text-end">${{ number_format((float) $item->line_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    @if ((float) $order->discount_amount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end text-muted">
                                                Discount @if ($order->coupon_code) <small>({{ $order->coupon_code }})</small> @endif
                                            </td>
                                            <td class="text-end text-success">-${{ number_format((float) $order->discount_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if ((float) $order->shipping_amount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end text-muted">Shipping</td>
                                            <td class="text-end">${{ number_format((float) $order->shipping_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if ((float) $order->tax_amount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end text-muted">Tax</td>
                                            <td class="text-end">${{ number_format((float) $order->tax_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Order Total</td>
                                        <td class="text-end fw-bold fs-5">${{ number_format((float) $order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Billing Address --}}
                    <div class="card mb-5">
                        <div class="card-header">
                            <strong>Billing Address</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-1">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</p>
                            <p class="mb-1">{{ $order->street_address }}{{ $order->apartment ? ', ' . $order->apartment : '' }}</p>
                            <p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                            <p class="mb-1">{{ $order->country }}</p>
                            <p class="mb-0 text-muted">{{ $order->customer_email }} &bull; {{ $order->customer_phone }}</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary me-3">Continue Shopping</a>
                        @auth
                            <a href="{{ route('account.orders.show', $order->order_number) }}" class="btn btn-outline-secondary">View Order</a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </section>
</x-app>
