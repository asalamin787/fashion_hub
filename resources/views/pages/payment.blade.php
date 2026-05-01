<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;600;700&family=Be+Vietnam+Pro:wght@400;500;600&display=swap" rel="stylesheet">
        <style>
            .checkout-section {
                padding: 84px 0;
                background: linear-gradient(180deg, #fcf9f8 0%, #f4efec 100%);
            }
            .checkout-shell {
                display: grid;
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .review-panel {
                order: 2;
            }
            .payment-panel {
                order: 1;
                border-radius: 14px;
                border: 1px solid #ece3df;
                background: rgba(255, 255, 255, 0.76);
                backdrop-filter: blur(8px);
                box-shadow: 0 20px 40px rgba(164, 92, 64, 0.05);
                padding: 28px 24px;
            }
            .premium-title {
                margin: 0 0 26px;
                font-family: 'Noto Serif', serif;
                font-size: 2rem;
                font-weight: 600;
                color: #1c1b1b;
                line-height: 1.2;
            }
            .review-list {
                display: flex;
                flex-direction: column;
                gap: 18px;
                margin-bottom: 22px;
            }
            .review-item {
                display: flex;
                gap: 16px;
            }
            .review-item-image {
                width: 84px;
                height: 108px;
                border-radius: 6px;
                overflow: hidden;
                background: #ebe7e5;
                flex-shrink: 0;
            }
            .review-item-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .review-item-content {
                min-width: 0;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                flex: 1;
            }
            .review-item-content h5 {
                margin: 0;
                font-family: 'Noto Serif', serif;
                font-size: 1.12rem;
                font-weight: 600;
                color: #1c1b1b;
                line-height: 1.25;
            }
            .review-item-meta {
                margin: 3px 0 0;
                font-family: 'Be Vietnam Pro', sans-serif;
                font-size: 0.72rem;
                letter-spacing: 0.11em;
                text-transform: uppercase;
                color: #86736c;
            }
            .review-item-bottom {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
                margin-top: 8px;
            }
            .review-item-qty {
                margin: 0;
                color: #6f6460;
                font-size: 0.84rem;
                font-style: italic;
            }
            .review-item-price {
                margin: 0;
                color: #86452a;
                font-size: 1rem;
                font-weight: 500;
                font-family: 'Be Vietnam Pro', sans-serif;
            }
            .review-totals {
                border-top: 1px solid #e7dbd6;
                padding-top: 16px;
                margin-top: 10px;
            }
            .review-totals .summary-row {
                border: 0;
                padding: 8px 0;
                margin: 0;
                font-family: 'Be Vietnam Pro', sans-serif;
                color: #1f1e1e;
            }
            .review-totals .summary-row span:first-child {
                color: #86736c;
            }
            .review-totals .summary-row.total {
                padding-top: 14px;
                margin-top: 8px;
                border-top: 0;
            }
            .review-totals .summary-row.total span {
                font-family: 'Noto Serif', serif;
                font-size: 2rem;
                font-weight: 600;
                color: #1c1b1b;
            }
            .review-totals .summary-row.total .value {
                color: #86452a;
            }
            .payment-section-title {
                margin: 0 0 20px;
                font-family: 'Noto Serif', serif;
                font-size: 2rem;
                font-weight: 600;
                color: #1c1b1b;
                line-height: 1.2;
            }
            .pm-header-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding-bottom: 14px;
                border-bottom: 1px solid #ece3df;
            }
            .pm-header-left {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .pm-header-icon {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                background: #6f3621;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }
            .pm-header-text h5 {
                margin: 0;
                font-family: 'Noto Serif', serif;
                font-size: 1.65rem;
                font-weight: 600;
                color: #1c1b1b;
            }
            .pm-header-text p {
                margin: 1px 0 0;
                color: #86736c;
                font-size: 0.92rem;
                font-family: 'Be Vietnam Pro', sans-serif;
            }
            .pm-selection-pill {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                border: 1px solid #d9c2ba;
                border-radius: 7px;
                background: #fff;
                padding: 8px 12px;
                color: #1c1b1b;
                font-size: 0.95rem;
                font-family: 'Be Vietnam Pro', sans-serif;
                white-space: nowrap;
            }
            .pm-selection-pill .pm-radio {
                width: 14px;
                height: 14px;
                accent-color: #86452a;
            }
            .pm-card-logos {
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }
            .pm-card-logos img {
                height: 16px;
                object-fit: contain;
            }
            .card-details-wrap {
                padding-top: 16px;
            }
            .card-details-header {
                display: flex;
                align-items: center;
                gap: 11px;
                margin-bottom: 16px;
            }
            .card-details-header .cd-icon-wrap {
                width: 40px;
                height: 40px;
                border-radius: 8px;
                background: rgba(134, 69, 42, 0.08);
                color: #86452a;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card-details-header h4 {
                margin: 0;
                font-family: 'Noto Serif', serif;
                font-size: 2rem;
                font-weight: 600;
                color: #1c1b1b;
            }
            .card-details-header p {
                margin: 2px 0 0;
                color: #86736c;
                font-size: 0.92rem;
            }
            .form-group {
                margin-bottom: 16px;
            }
            .stripe-field-label {
                display: block;
                margin: 0 0 6px;
                font-size: 0.85rem;
                color: #1c1b1b;
                font-family: 'Be Vietnam Pro', sans-serif;
                font-weight: 500;
            }
            .stripe-number-wrapper {
                position: relative;
            }
            .stripe-card-shell {
                display: flex;
                align-items: center;
                min-height: 44px;
                border: 1px solid #d9c2ba;
                border-radius: 6px;
                background: #fff;
                padding: 0 12px;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }
            .stripe-card-shell:focus-within {
                border-color: #86452a;
                box-shadow: 0 0 0 3px rgba(134, 69, 42, 0.12);
            }
            .stripe-card-element {
                width: 100%;
                padding: 12px 0;
            }
            .stripe-number-wrapper .stripe-card-shell {
                padding-right: 80px;
            }
            .stripe-number-brand-icons {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                display: flex;
                align-items: center;
                gap: 6px;
                pointer-events: none;
            }
            .stripe-number-brand-icons img {
                height: 18px;
                object-fit: contain;
            }
            .payment-input {
                width: 100%;
                min-height: 44px;
                border: 1px solid #d9c2ba;
                border-radius: 6px;
                padding: 10px 12px;
                outline: none;
                font-family: 'Be Vietnam Pro', sans-serif;
                font-size: 0.95rem;
                color: #1f1e1e;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }
            .payment-input:focus {
                border-color: #86452a;
                box-shadow: 0 0 0 3px rgba(134, 69, 42, 0.12);
            }
            .stripe-ready-status {
                margin-top: 10px;
                border-radius: 6px;
                background: #f2eeec;
                color: #6d635f;
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                font-size: 0.76rem;
                font-family: 'Be Vietnam Pro', sans-serif;
            }
            .security-trust-badge {
                margin-top: 12px;
                border: 1px solid #eadfd9;
                border-radius: 8px;
                background: #fbf8f6;
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 11px 12px;
            }
            .security-trust-badge .stb-icon {
                width: 28px;
                height: 28px;
                border-radius: 8px;
                background: #6f3621;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.82rem;
                flex-shrink: 0;
            }
            .security-trust-badge h6 {
                margin: 0;
                color: #2a2929;
                font-size: 0.92rem;
                font-family: 'Be Vietnam Pro', sans-serif;
                font-weight: 500;
            }
            .security-trust-badge p {
                margin: 2px 0 0;
                color: #7a706c;
                font-size: 0.78rem;
                font-family: 'Be Vietnam Pro', sans-serif;
            }
            .pay-btn {
                width: 100%;
                min-height: 52px;
                border: 0;
                border-radius: 8px;
                background: var(--secondary-color, #86452a);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                font-family: 'Noto Serif', serif;
                font-size: 2rem;
                font-weight: 600;
                letter-spacing: 0;
                box-shadow: 0 8px 20px rgba(110, 55, 33, 0.3);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .pay-btn:hover,
            .pay-btn:focus {
                transform: translateY(-1px);
                box-shadow: 0 12px 24px rgba(110, 55, 33, 0.34);
                color: #fff;
            }
            .pay-btn i {
                font-size: 1.1rem;
            }
            .stripe-footer {
                margin-top: 16px;
                padding-top: 12px;
                border-top: 1px solid #ece3df;
                text-align: center;
            }
            .stripe-footer .stripe-brand {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                color: #86736c;
                font-size: 0.86rem;
                font-family: 'Be Vietnam Pro', sans-serif;
            }
            .stripe-footer .stripe-brand img {
                height: 19px;
            }
            .stripe-footer .stripe-badges {
                margin-top: 8px;
                display: flex;
                justify-content: center;
                gap: 20px;
                color: #86736c;
                font-size: 0.78rem;
            }
            .summary-trust-badge {
                margin-top: 18px;
                border: 1px solid #eadfd9;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 13px 14px;
            }
            .summary-trust-badge .stb-icon {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: rgba(134, 69, 42, 0.12);
                color: #86452a;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .summary-trust-badge h6 {
                margin: 0;
                color: #2a2929;
                font-size: 0.88rem;
                font-family: 'Be Vietnam Pro', sans-serif;
                font-weight: 500;
            }
            .summary-trust-badge p {
                margin: 2px 0 0;
                color: #7a706c;
                font-size: 0.79rem;
                font-family: 'Be Vietnam Pro', sans-serif;
            }
            .payment-info-card {
                border: 1px solid #e7dbd6;
                border-radius: 12px;
                padding: 20px;
                text-align: center;
                background: #fff;
            }
            .payment-info-card .pic-icon {
                width: 58px;
                height: 58px;
                border-radius: 50%;
                background: rgba(134, 69, 42, 0.1);
                color: #86452a;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 16px;
                font-size: 1.4rem;
            }
            @media (min-width: 992px) {
                .checkout-shell {
                    grid-template-columns: minmax(360px, 42%) minmax(0, 58%);
                    gap: 62px;
                    align-items: start;
                }
                .review-panel {
                    order: 1;
                }
                .payment-panel {
                    order: 2;
                    padding: 38px;
                }
            }
            @media (max-width: 767.98px) {
                .checkout-section {
                    padding: 56px 0;
                }
                .premium-title,
                .payment-section-title,
                .card-details-header h4,
                .review-totals .summary-row.total span {
                    font-size: 1.65rem;
                }
                .pay-btn {
                    font-size: 1.55rem;
                }
                .pm-header-card {
                    align-items: flex-start;
                    flex-direction: column;
                }
                .pm-selection-pill {
                    white-space: normal;
                }
            }
        </style>
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>Payment</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('checkout') }}">Checkout</a></li>
                    <li class="breadcrumb-item active">Payment</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="checkout-section">
        <div class="container">
            <div class="checkout-shell">

                <section class="review-panel">
                    <h2 class="premium-title">Review Order</h2>

                    <div class="review-list">
                        @forelse ($order->items as $item)
                            @php
                                $itemImage = $item->image && ! str_starts_with($item->image, 'http')
                                    ? asset('storage/' . $item->image)
                                    : $item->image;
                            @endphp
                            <article class="review-item">
                                <div class="review-item-image">
                                    <img src="{{ $itemImage }}" alt="{{ $item->product_name }}">
                                </div>
                                <div class="review-item-content">
                                    <div>
                                        <h5>{{ $item->product_name }}</h5>
                                        <p class="review-item-meta">FashionHub Selection</p>
                                    </div>
                                    <div class="review-item-bottom">
                                        <p class="review-item-qty">Qty {{ $item->quantity }}</p>
                                        <p class="review-item-price">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-muted">No items in order.</p>
                        @endforelse
                    </div>

                    <div class="review-totals">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="value">${{ number_format($order->subtotal ?? 0, 2) }}</span>
                        </div>

                        @if($order->discount_amount > 0)
                            <div class="summary-row">
                                <span>Discount</span>
                                <span class="value text-success">-${{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="summary-row">
                            <span>Shipping</span>
                            <span class="value">{{ $order->shipping_amount > 0 ? '$' . number_format($order->shipping_amount, 2) : '$0.00' }}</span>
                        </div>

                        @if($order->tax_amount > 0)
                            <div class="summary-row">
                                <span>Tax</span>
                                <span class="value">${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="value">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="summary-trust-badge">
                        <div class="stb-icon"><i class="fas fa-lock"></i></div>
                        <div>
                            <h6>All transactions are secure and encrypted.</h6>
                            <p>Your information is protected.</p>
                        </div>
                    </div>
                </section>

                <section class="payment-panel">
                    <h2 class="payment-section-title">Payment Information</h2>

                    <div class="form-section p-0 mb-4 border-0 bg-transparent">
                        <div class="pm-header-card">
                            <div class="pm-header-left">
                                @if($order->payment_method === \App\Enums\PaymentMethod::CreditCard)
                                    <div class="pm-header-icon"><i class="fas fa-credit-card"></i></div>
                                @elseif($order->payment_method === \App\Enums\PaymentMethod::Paypal)
                                    <div class="pm-header-icon"><i class="fab fa-paypal"></i></div>
                                @else
                                    <div class="pm-header-icon"><i class="fas fa-money-bill-wave"></i></div>
                                @endif
                                <div class="pm-header-text">
                                    <h5>Payment Method</h5>
                                    <p>Choose how you'd like to pay</p>
                                </div>
                            </div>

                            @if($order->payment_method === \App\Enums\PaymentMethod::CreditCard)
                                <div class="pm-selection-pill">
                                    <input type="radio" class="pm-radio" checked readonly>
                                    <span>Credit / Debit Card</span>
                                    <div class="pm-card-logos">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard">
                                    </div>
                                </div>
                            @elseif($order->payment_method === \App\Enums\PaymentMethod::Paypal)
                                <div class="pm-selection-pill">
                                    <input type="radio" class="pm-radio" checked readonly>
                                    <span>PayPal</span>
                                </div>
                            @else
                                <div class="pm-selection-pill">
                                    <input type="radio" class="pm-radio" checked readonly>
                                    <span>Cash on Delivery</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($order->payment_method === \App\Enums\PaymentMethod::CreditCard)
                        <form id="payment-form" class="card-details-wrap">
                            @csrf

                            <div class="card-details-header">
                                <div class="cd-icon-wrap"><i class="fas fa-credit-card"></i></div>
                                <div>
                                    <h4>Card Details</h4>
                                    <p>Enter your card information securely</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="stripe-field-label">Card number</label>
                                <div class="stripe-number-wrapper">
                                    <div class="stripe-card-shell" id="stripe-card-number-shell">
                                        <div id="stripe-card-number-element" class="stripe-card-element"></div>
                                    </div>
                                    <div class="stripe-number-brand-icons">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard">
                                    </div>
                                </div>
                                <div id="stripe-card-status" class="stripe-ready-status" style="display:none;">
                                    <i class="fas fa-lock"></i>
                                    <span>Secure card field is ready. Start typing card number.</span>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-7">
                                    <label class="stripe-field-label">Cardholder name</label>
                                    <input
                                        type="text"
                                        id="cardholder-name"
                                        class="payment-input"
                                        placeholder="Name on card"
                                        autocomplete="cc-name"
                                    >
                                </div>
                                <div class="col-md-5">
                                    <label class="stripe-field-label">CVC</label>
                                    <div class="stripe-card-shell" id="stripe-card-cvc-shell">
                                        <div id="stripe-card-cvc-element" class="stripe-card-element"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="stripe-field-label">Expiry date</label>
                                <div class="stripe-card-shell" id="stripe-card-expiry-shell">
                                    <div id="stripe-card-expiry-element" class="stripe-card-element"></div>
                                </div>
                            </div>

                            <div class="security-trust-badge">
                                <div class="stb-icon"><i class="fas fa-shield-alt"></i></div>
                                <div>
                                    <h6>Your payment information is safe with us.</h6>
                                    <p>We use industry-standard encryption to protect your data.</p>
                                </div>
                            </div>

                            <div id="stripe-config-warning" class="alert alert-warning mt-3 mb-0" style="display:none;">
                                Stripe publishable key is missing. Please configure <strong>STRIPE_PUBLISHABLE_KEY</strong> in .env.
                            </div>

                            <div id="payment-error" class="alert alert-danger mt-3 mb-3" style="display:none;"></div>

                            <button id="pay-button" type="button" class="pay-btn mt-4">
                                <i class="fas fa-lock"></i>
                                Pay ${{ number_format($order->total_amount, 2) }}
                            </button>

                            <div class="stripe-footer">
                                <div class="stripe-brand">
                                    Payment processed securely by
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/2560px-Stripe_Logo%2C_revised_2016.svg.png" alt="Stripe">
                                </div>
                                <div class="stripe-badges">
                                    <span><i class="fas fa-check-circle"></i> PCI-DSS Compliant</span>
                                    <span><i class="fas fa-lock"></i> Secure SSL</span>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="payment-info-card">
                            @if($order->payment_method === \App\Enums\PaymentMethod::Paypal)
                                <div class="pic-icon"><i class="fab fa-paypal"></i></div>
                                <h5 class="fw-700 mb-2">PayPal Payment</h5>
                                <p class="text-muted mb-4">You will be redirected to PayPal to complete your payment.</p>
                            @else
                                <div class="pic-icon"><i class="fas fa-truck"></i></div>
                                <h5 class="fw-700 mb-2">Cash on Delivery</h5>
                                <p class="text-muted mb-4">Your order is confirmed! Please have the exact amount ready when the delivery arrives.</p>
                            @endif

                            <a href="{{ route('order.confirmation', ['orderNumber' => $order->order_number]) }}" class="btn btn-primary w-100 mt-2">
                                Continue to Order Confirmation
                            </a>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </section>

    @if($order->payment_method === \App\Enums\PaymentMethod::CreditCard)
        @push('js')
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                const payButton = document.getElementById('pay-button');
                const paymentErrorEl = document.getElementById('payment-error');
                const stripeConfigWarning = document.getElementById('stripe-config-warning');
                const stripeCardStatusEl = document.getElementById('stripe-card-status');
                const stripePublishableKey = @json($stripePublishableKey);
                const clientSecret = @json($clientSecret);
                const orderNumber = @json($order->order_number);
                const processPaymentUrl = @json(route('payment.process.stripe', ['orderNumber' => $order->order_number]));

                let stripe = null;
                let cardNumberElement = null;
                let cardExpiryElement = null;
                let cardCvcElement = null;
                let stripeElementMounted = false;

                if (stripePublishableKey) {
                    stripe = Stripe(stripePublishableKey);
                } else {
                    stripeConfigWarning.style.display = '';
                }

                function mountStripeCardElement() {
                    if (!stripe || stripeElementMounted) {
                        return;
                    }

                    const stripeElements = stripe.elements();

                    const elementStyle = {
                        base: {
                            fontSize: '16px',
                            color: '#111827',
                            fontFamily: 'ui-sans-serif, system-ui, -apple-system, Segoe UI, sans-serif',
                            fontWeight: '500',
                            '::placeholder': { color: '#9ca3af' },
                        },
                        invalid: { color: '#b91c1c' },
                    };

                    cardNumberElement = stripeElements.create('cardNumber', { style: elementStyle, showIcon: true });
                    cardExpiryElement = stripeElements.create('cardExpiry', { style: elementStyle });
                    cardCvcElement    = stripeElements.create('cardCvc',    { style: elementStyle });

                    cardNumberElement.mount('#stripe-card-number-element');
                    cardExpiryElement.mount('#stripe-card-expiry-element');
                    cardCvcElement.mount('#stripe-card-cvc-element');

                    // click-to-focus shells
                    document.getElementById('stripe-card-number-shell')?.addEventListener('click', () => cardNumberElement.focus());
                    document.getElementById('stripe-card-expiry-shell')?.addEventListener('click', () => cardExpiryElement.focus());
                    document.getElementById('stripe-card-cvc-shell')?.addEventListener('click', () => cardCvcElement.focus());

                    const onStripeChange = (event) => {
                        if (event.error) {
                            showPaymentError(event.error.message);
                            stripeCardStatusEl.style.display = '';
                            stripeCardStatusEl.querySelector('span').textContent = event.error.message;
                            stripeCardStatusEl.style.background = '#fef2f2';
                            stripeCardStatusEl.style.color = '#b91c1c';
                            stripeCardStatusEl.querySelector('i').className = 'fas fa-exclamation-circle';
                            return;
                        }
                        clearPaymentError();
                    };

                    cardNumberElement.on('change', onStripeChange);
                    cardExpiryElement.on('change', onStripeChange);
                    cardCvcElement.on('change', onStripeChange);

                    cardNumberElement.on('ready', () => {
                        stripeCardStatusEl.style.display = '';
                    });

                    stripeElementMounted = true;
                }

                function setLoadingState(isLoading) {
                    payButton.disabled = isLoading;
                    payButton.innerHTML = isLoading
                        ? '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing Payment...'
                        : '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($order->total_amount, 2) }}';
                }

                function showPaymentError(message) {
                    paymentErrorEl.style.display = '';
                    paymentErrorEl.textContent = message;
                    paymentErrorEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }

                function clearPaymentError() {
                    paymentErrorEl.style.display = 'none';
                    paymentErrorEl.textContent = '';
                }

                async function confirmOrderPayment(paymentIntentId) {
                    const response = await fetch(processPaymentUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ order_number: orderNumber, payment_intent_id: paymentIntentId }),
                    });
                    const payload = await response.json();
                    if (!response.ok) {
                        throw new Error(payload.message || 'Unable to verify payment status.');
                    }
                    return payload;
                }

                mountStripeCardElement();

                payButton.addEventListener('click', async function () {
                    clearPaymentError();

                    if (!stripe || !cardNumberElement) {
                        showPaymentError('Stripe configuration is missing. Please contact support.');
                        return;
                    }

                    try {
                        setLoadingState(true);

                        const cardholderName = document.getElementById('cardholder-name')?.value?.trim() || '';

                        const stripeResult = await stripe.confirmCardPayment(clientSecret, {
                            payment_method: {
                                card: cardNumberElement,
                                billing_details: { name: cardholderName },
                            },
                        });

                        if (stripeResult.error) {
                            showPaymentError(stripeResult.error.message || 'Card payment failed.');
                            setLoadingState(false);
                            return;
                        }

                        const confirmPayload = await confirmOrderPayment(stripeResult.paymentIntent.id);

                        if (confirmPayload.redirect_url) {
                            window.location.href = confirmPayload.redirect_url;
                            return;
                        }

                        showPaymentError('Payment was processed, but redirect failed. Please refresh your orders page.');
                    } catch (error) {
                        showPaymentError(error.message || 'Unable to process card payment.');
                    } finally {
                        setLoadingState(false);
                    }
                });
            </script>
        @endpush
    @endif
</x-app>
