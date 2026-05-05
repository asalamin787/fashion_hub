<x-app>
    @php
        $paymentMethodLabel = $order->payment_method
            ? ucwords(str_replace('_', ' ', $order->payment_method->value))
            : 'N/A';

        $orderStatusLabel = $order->order_status
            ? ucwords(str_replace('_', ' ', $order->order_status->value))
            : 'Pending';

        $billingAddressLine = $order->street_address.($order->apartment ? ', '.$order->apartment : '');
        $shippingAddress = $order->shippingAddress();
        $shippingAddressLine = $shippingAddress['line_1'].($shippingAddress['line_2'] ? ', '.$shippingAddress['line_2'] : '');
    @endphp

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

    <section class="py-5">
        <div class="container">
            <div class="alert alert-success mb-4" role="alert">
                <h4 class="alert-heading mb-2">Thank you. Your order is confirmed.</h4>
                <p class="mb-0">We sent confirmation to {{ $order->customer_email }}.</p>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Order Number</small>
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Placed On</small>
                            <strong>{{ $order->placed_at?->format('d M Y, h:i A') ?? $order->created_at->format('d M Y, h:i A') }}</strong>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Payment Method</small>
                            <strong>{{ $paymentMethodLabel }}</strong>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Order Status</small>
                            <strong>{{ $orderStatusLabel }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <strong>Items Ordered</strong>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-end">Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            @php
                                                $itemImage = $item->image && ! str_starts_with($item->image, 'http')
                                                    ? asset('storage/'.ltrim($item->image, '/'))
                                                    : $item->image;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if ($itemImage)
                                                            <img src="{{ $itemImage }}" alt="{{ $item->product_name }}"
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
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header"><strong>Billing Address</strong></div>
                                <div class="card-body">
                                    <p class="mb-1">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</p>
                                    <p class="mb-1">{{ $billingAddressLine }}</p>
                                    <p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                                    <p class="mb-1">{{ $order->country }}</p>
                                    <p class="mb-0 text-muted">{{ $order->customer_email }} &bull; {{ $order->customer_phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header"><strong>Shipping Address</strong></div>
                                <div class="card-body">
                                    <p class="mb-1">{{ $shippingAddress['name'] }}</p>
                                    <p class="mb-1">{{ $shippingAddressLine }}</p>
                                    <p class="mb-1">{{ $shippingAddress['city'] }}, {{ $shippingAddress['state'] }} {{ $shippingAddress['postal_code'] }}</p>
                                    <p class="mb-1">{{ $shippingAddress['country'] }}</p>
                                    <p class="mb-0 text-muted">{{ $shippingAddress['email'] }} &bull; {{ $shippingAddress['phone'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><strong>Order Summary</strong></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <strong>${{ number_format((float) $order->subtotal, 2) }}</strong>
                            </div>
                            @if ((float) $order->discount_amount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount @if ($order->coupon_code)
                                            ({{ $order->coupon_code }})
                                        @endif
                                    </span>
                                    <strong class="text-success">-${{ number_format((float) $order->discount_amount, 2) }}</strong>
                                </div>
                            @endif
                            @if ((float) $order->shipping_amount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping</span>
                                    <strong>${{ number_format((float) $order->shipping_amount, 2) }}</strong>
                                </div>
                            @endif
                            @if ((float) $order->tax_amount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax</span>
                                    <strong>${{ number_format((float) $order->tax_amount, 2) }}</strong>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <strong class="fs-5">${{ number_format((float) $order->total_amount, 2) }}</strong>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                                @auth
                                    <a href="{{ route('account.orders.show', $order->order_number) }}"
                                        class="btn btn-outline-secondary">View Order</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('css')
        <style>
            .page-header {
                background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                padding: 60px 0;
                color: var(--white);
                text-align: center;
            }

            .page-header h1 {
                font-size: 3rem;
                font-weight: 700;
                color: var(--white);
                margin-bottom: 20px;
            }

            .page-header .breadcrumb {
                background: transparent;
                justify-content: center;
                margin: 0;
                padding: 0;
            }

            .page-header .breadcrumb-item {
                color: rgba(255, 255, 255, 0.8);
            }

            .page-header .breadcrumb-item a {
                color: var(--white);
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .page-header .breadcrumb-item a:hover {
                color: var(--secondary-color);
            }

            .page-header .breadcrumb-item.active {
                color: var(--secondary-color);
            }

            .page-header .breadcrumb-item + .breadcrumb-item::before {
                color: rgba(255, 255, 255, 0.6);
            }
        </style>
    @endpush
</x-app>
