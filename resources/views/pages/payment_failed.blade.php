<x-app>
    <section class="page-header">
        <div class="container">
            <h1>Payment Failed</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payment Failed</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3">Your payment could not be completed.</h2>
                    <p class="text-muted mb-4">
                        Order <strong>{{ $order->order_number }}</strong> is still available. You can retry payment from checkout.
                    </p>

                    <a href="{{ route('checkout') }}" class="btn btn-primary me-2">Try Again</a>
                    <a href="{{ route('cart') }}" class="btn btn-outline-secondary">Back to Cart</a>
                </div>
            </div>
        </div>
    </section>
</x-app>
