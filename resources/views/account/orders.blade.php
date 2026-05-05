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
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h1 class="h3 fw-bold mb-1">My Orders</h1>
                                    <p class="text-muted mb-0">A full history of your purchases, statuses, and totals.</p>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4">Continue shopping</a>
                            </div>

                            @if ($orders->isEmpty())
                                <div class="text-center py-5">
                                    <h2 class="h5">Your order history is empty</h2>
                                    <p class="text-muted mb-4">You have not placed any orders yet.</p>
                                    <a href="{{ route('shop') }}" class="btn btn-outline-dark rounded-pill px-4">Browse products</a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Placed</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Order Status</th>
                                                <th>Payment</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td class="fw-semibold">{{ $order->order_number }}</td>
                                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                                    <td>{{ $order->items()->count() }}</td>
                                                    <td>${{ number_format((float) $order->total_amount, 2) }}</td>
                                                    <td><span class="badge text-bg-{{ $statusColor($order->order_status->value) }}">{{ ucfirst($order->order_status->value) }}</span></td>
                                                    <td><span class="badge text-bg-{{ $statusColor($order->payment_status->value) }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status->value)) }}</span></td>
                                                    <td class="text-end"><a href="{{ route('account.orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-dark rounded-pill">Details</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">{{ $orders->links() }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
