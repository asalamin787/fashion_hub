<x-app>
    <section class="page-header">
        <div class="container">
            <h1>Payment Successful</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payment Successful</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3">Thank you. Your payment was successful.</h2>
                    <p class="text-muted mb-4">
                        Order <strong>{{ $order->order_number }}</strong> has been confirmed and is now being processed.
                    </p>

                    <a href="{{ route('order.confirmation', ['orderNumber' => $order->order_number]) }}" class="btn btn-primary me-2">
                        View Order Details
                    </a>
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>
</x-app>
