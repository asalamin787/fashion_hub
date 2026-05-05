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
                <div class="col-lg-3">
                    @include('account.partials.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4 p-lg-5">
                            <span class="badge rounded-pill text-bg-light mb-3">Customer Dashboard</span>
                            <h1 class="h2 fw-bold mb-2">Welcome back, {{ $user->name }}</h1>
                            <p class="text-muted mb-0">Track orders, update your details, and stay on top of every purchase from one polished account hub.</p>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><div class="text-muted small mb-2">Total Orders</div><div class="display-6 fw-bold">{{ $orderCount }}</div></div></div></div>
                        <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><div class="text-muted small mb-2">Pending Orders</div><div class="display-6 fw-bold">{{ $pendingOrders }}</div></div></div></div>
                        <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><div class="text-muted small mb-2">Completed Orders</div><div class="display-6 fw-bold">{{ $completedOrders }}</div></div></div></div>
                        <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4"><div class="text-muted small mb-2">Lifetime Spend</div><div class="display-6 fw-bold">${{ number_format($spentTotal, 2) }}</div></div></div></div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="h4 mb-0">Recent Orders</h2>
                                <a href="{{ route('account.orders') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">View all orders</a>
                            </div>

                            @if ($orders->isEmpty())
                                <div class="text-center py-5">
                                    <h3 class="h5">No orders yet</h3>
                                    <p class="text-muted mb-4">Once you place your first order, it will appear here with live status tracking.</p>
                                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4">Start shopping</a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
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
                                                    <td>${{ number_format((float) $order->total_amount, 2) }}</td>
                                                    <td><span class="badge text-bg-{{ $statusColor($order->order_status->value) }}">{{ ucfirst($order->order_status->value) }}</span></td>
                                                    <td><span class="badge text-bg-{{ $statusColor($order->payment_status->value) }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status->value)) }}</span></td>
                                                    <td class="text-end"><a href="{{ route('account.orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-dark rounded-pill">View</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
