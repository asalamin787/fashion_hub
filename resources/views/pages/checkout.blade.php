<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>Checkout</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="checkout-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-form">
                        <div class="form-section">
                            <h4 class="section-title-small">Billing Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName" class="form-label">First Name *</label>
                                        <input type="text" class="form-control" id="firstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" id="lastName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="company" class="form-label">Company Name (Optional)</label>
                                <input type="text" class="form-control" id="company">
                            </div>
                            <div class="form-group">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-control" id="country" required>
                                    <option value="">Select Country</option>
                                    <option value="us">United States</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="ca">Canada</option>
                                    <option value="au">Australia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address" class="form-label">Street Address *</label>
                                <input type="text" class="form-control" id="address"
                                    placeholder="House number and street name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control"
                                    placeholder="Apartment, suite, unit, etc. (optional)">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="city" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state" class="form-label">State *</label>
                                        <input type="text" class="form-control" id="state" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="zip" class="form-label">ZIP Code *</label>
                                        <input type="text" class="form-control" id="zip" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="form-label">Order Notes (Optional)</label>
                                <textarea class="form-control" id="notes" rows="4"
                                    placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title-small">Payment Method</h4>
                            <div class="payment-methods">
                                <div class="payment-option active">
                                    <label>
                                        <input type="radio" name="payment" value="card" checked>
                                        <i class="fas fa-credit-card"></i>
                                        Credit / Debit Card
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <label>
                                        <input type="radio" name="payment" value="paypal">
                                        <i class="fab fa-paypal"></i>
                                        PayPal
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <label>
                                        <input type="radio" name="payment" value="cod">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">
                                I have read and agree to the website <a href="{{ route('terms.of.condition') }}">Terms & Conditions</a> *
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-summary-box">
                        <h4 class="summary-title">Your Order</h4>

                        <div class="summary-item">
                            <div class="summary-item-image">
                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400"
                                    alt="Product">
                            </div>
                            <div class="summary-item-info">
                                <h6>Elegant Summer Dress</h6>
                                <p class="summary-item-meta">Size: M | Qty: 1</p>
                            </div>
                            <div class="summary-item-price">$129.99</div>
                        </div>

                        <div class="summary-item">
                            <div class="summary-item-image">
                                <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                    alt="Product">
                            </div>
                            <div class="summary-item-info">
                                <h6>Designer Handbag</h6>
                                <p class="summary-item-meta">Qty: 1</p>
                            </div>
                            <div class="summary-item-price">$199.99</div>
                        </div>

                        <div class="summary-item">
                            <div class="summary-item-image">
                                <img src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400"
                                    alt="Product">
                            </div>
                            <div class="summary-item-info">
                                <h6>Classic White Sneakers</h6>
                                <p class="summary-item-meta">Size: 42 | Qty: 2</p>
                            </div>
                            <div class="summary-item-price">$159.98</div>
                        </div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="value">$489.96</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span class="value">$10.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span class="value">$49.00</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="value">$548.96</span>
                        </div>

                        <div class="summary-buttons">
                            <button class="btn btn-primary">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            document.querySelectorAll('.payment-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    this.querySelector('input[type="radio"]').checked = true;
                });
            });
        </script>
    @endpush
</x-app>
