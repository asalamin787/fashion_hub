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

            {{-- Global errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" novalidate>
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-form">

                            {{-- â”€â”€â”€ Billing Details â”€â”€â”€ --}}
                            <div class="form-section">
                                <h4 class="section-title-small">Billing Details</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">First Name *</label>
                                            <input type="text"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   id="first_name" name="first_name"
                                                   value="{{ old('first_name', $prefill['first_name']) }}"
                                                   required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" class="form-label">Last Name *</label>
                                            <input type="text"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   id="last_name" name="last_name"
                                                   value="{{ old('last_name', $prefill['last_name']) }}"
                                                   required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email"
                                           value="{{ old('email', $prefill['email']) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone"
                                           value="{{ old('phone', $prefill['phone']) }}"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="company_name" class="form-label">Company Name <span class="text-muted">(Optional)</span></label>
                                    <input type="text"
                                           class="form-control @error('company_name') is-invalid @enderror"
                                           id="company_name" name="company_name"
                                           value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="country" class="form-label">Country *</label>
                                    <select class="form-control @error('country') is-invalid @enderror"
                                            id="country" name="country" required>
                                        <option value="">Select Country</option>
                                        <option value="US" {{ old('country', $prefill['country']) === 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="GB" {{ old('country', $prefill['country']) === 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="CA" {{ old('country', $prefill['country']) === 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="AU" {{ old('country', $prefill['country']) === 'AU' ? 'selected' : '' }}>Australia</option>
                                        <option value="BD" {{ old('country', $prefill['country']) === 'BD' ? 'selected' : '' }}>Bangladesh</option>
                                        <option value="IN" {{ old('country', $prefill['country']) === 'IN' ? 'selected' : '' }}>India</option>
                                        <option value="DE" {{ old('country', $prefill['country']) === 'DE' ? 'selected' : '' }}>Germany</option>
                                        <option value="FR" {{ old('country', $prefill['country']) === 'FR' ? 'selected' : '' }}>France</option>
                                        <option value="AE" {{ old('country', $prefill['country']) === 'AE' ? 'selected' : '' }}>United Arab Emirates</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="street_address" class="form-label">Street Address *</label>
                                    <input type="text"
                                           class="form-control @error('street_address') is-invalid @enderror"
                                           id="street_address" name="street_address"
                                           placeholder="House number and street name"
                                           value="{{ old('street_address', $prefill['street_address']) }}"
                                           required>
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text"
                                           class="form-control @error('apartment') is-invalid @enderror"
                                           name="apartment"
                                           placeholder="Apartment, suite, unit, etc. (optional)"
                                           value="{{ old('apartment') }}">
                                    @error('apartment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text"
                                                   class="form-control @error('city') is-invalid @enderror"
                                                   id="city" name="city"
                                                   value="{{ old('city', $prefill['city']) }}"
                                                   required>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state" class="form-label">State *</label>
                                            <input type="text"
                                                   class="form-control @error('state') is-invalid @enderror"
                                                   id="state" name="state"
                                                   value="{{ old('state') }}"
                                                   required>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="zip_code" class="form-label">ZIP Code *</label>
                                            <input type="text"
                                                   class="form-control @error('zip_code') is-invalid @enderror"
                                                   id="zip_code" name="zip_code"
                                                   value="{{ old('zip_code') }}"
                                                   required>
                                            @error('zip_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="order_notes" class="form-label">Order Notes <span class="text-muted">(Optional)</span></label>
                                    <textarea class="form-control @error('order_notes') is-invalid @enderror"
                                              id="order_notes" name="order_notes" rows="4"
                                              placeholder="Notes about your order, e.g. special notes for delivery">{{ old('order_notes') }}</textarea>
                                    @error('order_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- â”€â”€â”€ Ship to Different Address â”€â”€â”€ --}}
                            <div class="form-section">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"
                                           id="shipping_toggle"
                                           {{ old('shipping_same_as_billing', '1') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="shipping_toggle">
                                        Ship to a different address?
                                    </label>
                                </div>

                                <div id="shipping-address-fields" style="{{ old('shipping_same_as_billing', '1') === '0' ? '' : 'display:none' }}">
                                    {{-- Hidden field â€” 1 when same, 0 when different --}}
                                    <input type="hidden" name="shipping_same_as_billing" id="shipping_same_as_billing_field" value="{{ old('shipping_same_as_billing', '1') }}">

                                    <h4 class="section-title-small mt-3">Shipping Address</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">First Name *</label>
                                                <input type="text"
                                                       class="form-control @error('shipping_first_name') is-invalid @enderror"
                                                       name="shipping_first_name"
                                                       value="{{ old('shipping_first_name') }}">
                                                @error('shipping_first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Last Name *</label>
                                                <input type="text"
                                                       class="form-control @error('shipping_last_name') is-invalid @enderror"
                                                       name="shipping_last_name"
                                                       value="{{ old('shipping_last_name') }}">
                                                @error('shipping_last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Phone *</label>
                                        <input type="tel"
                                               class="form-control @error('shipping_phone') is-invalid @enderror"
                                               name="shipping_phone"
                                               value="{{ old('shipping_phone') }}">
                                        @error('shipping_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Country *</label>
                                        <select class="form-control @error('shipping_country') is-invalid @enderror"
                                                name="shipping_country">
                                            <option value="">Select Country</option>
                                            <option value="US" {{ old('shipping_country') === 'US' ? 'selected' : '' }}>United States</option>
                                            <option value="GB" {{ old('shipping_country') === 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="CA" {{ old('shipping_country') === 'CA' ? 'selected' : '' }}>Canada</option>
                                            <option value="AU" {{ old('shipping_country') === 'AU' ? 'selected' : '' }}>Australia</option>
                                            <option value="BD" {{ old('shipping_country') === 'BD' ? 'selected' : '' }}>Bangladesh</option>
                                            <option value="IN" {{ old('shipping_country') === 'IN' ? 'selected' : '' }}>India</option>
                                            <option value="DE" {{ old('shipping_country') === 'DE' ? 'selected' : '' }}>Germany</option>
                                            <option value="FR" {{ old('shipping_country') === 'FR' ? 'selected' : '' }}>France</option>
                                            <option value="AE" {{ old('shipping_country') === 'AE' ? 'selected' : '' }}>United Arab Emirates</option>
                                        </select>
                                        @error('shipping_country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Street Address *</label>
                                        <input type="text"
                                               class="form-control @error('shipping_street_address') is-invalid @enderror"
                                               name="shipping_street_address"
                                               placeholder="House number and street name"
                                               value="{{ old('shipping_street_address') }}">
                                        @error('shipping_street_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control @error('shipping_apartment') is-invalid @enderror"
                                               name="shipping_apartment"
                                               placeholder="Apartment, suite, unit, etc. (optional)"
                                               value="{{ old('shipping_apartment') }}">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">City *</label>
                                                <input type="text"
                                                       class="form-control @error('shipping_city') is-invalid @enderror"
                                                       name="shipping_city"
                                                       value="{{ old('shipping_city') }}">
                                                @error('shipping_city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">State *</label>
                                                <input type="text"
                                                       class="form-control @error('shipping_state') is-invalid @enderror"
                                                       name="shipping_state"
                                                       value="{{ old('shipping_state') }}">
                                                @error('shipping_state')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">ZIP Code *</label>
                                                <input type="text"
                                                       class="form-control @error('shipping_zip_code') is-invalid @enderror"
                                                       name="shipping_zip_code"
                                                       value="{{ old('shipping_zip_code') }}">
                                                @error('shipping_zip_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- â”€â”€â”€ Payment Method â”€â”€â”€ --}}
                            <div class="form-section">
                                <h4 class="section-title-small">Payment Method</h4>
                                <div class="payment-methods">
                                    <div class="payment-option {{ old('payment_method', 'cash_on_delivery') === 'credit_card' ? 'active' : '' }}">
                                        <label>
                                            <input type="radio" name="payment_method" value="credit_card"
                                                   {{ old('payment_method', 'cash_on_delivery') === 'credit_card' ? 'checked' : '' }}>
                                            <i class="fas fa-credit-card"></i>
                                            Credit / Debit Card
                                        </label>
                                    </div>
                                    <div class="payment-option {{ old('payment_method', 'cash_on_delivery') === 'google_pay' ? 'active' : '' }}">
                                        <label>
                                            <input type="radio" name="payment_method" value="google_pay"
                                                   {{ old('payment_method', 'cash_on_delivery') === 'google_pay' ? 'checked' : '' }}>
                                            <i class="fab fa-google-pay"></i>
                                            Google Pay
                                        </label>
                                    </div>
                                    {{-- <div class="payment-option {{ old('payment_method', 'cash_on_delivery') === 'paypal' ? 'active' : '' }}">
                                        <label>
                                            <input type="radio" name="payment_method" value="paypal"
                                                   {{ old('payment_method', 'cash_on_delivery') === 'paypal' ? 'checked' : '' }}>
                                            <i class="fab fa-paypal"></i>
                                            PayPal
                                        </label>
                                    </div> --}}
                                    <div class="payment-option {{ old('payment_method', 'cash_on_delivery') === 'cash_on_delivery' ? 'active' : '' }}">
                                        <label>
                                            <input type="radio" name="payment_method" value="cash_on_delivery"
                                                   {{ old('payment_method', 'cash_on_delivery') === 'cash_on_delivery' ? 'checked' : '' }}>
                                            <i class="fas fa-money-bill-wave"></i>
                                            Cash on Delivery
                                        </label>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="terms-checkbox">
                                <input type="checkbox" id="terms" name="terms" value="1"
                                       {{ old('terms') ? 'checked' : '' }}>
                                <label for="terms">
                                    I have read and agree to the website <a href="{{ route('terms.of.condition') }}">Terms &amp; Conditions</a> *
                                </label>
                                @error('terms')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- â”€â”€â”€ Order Summary â”€â”€â”€ --}}
                    <div class="col-lg-4">
                        <div class="order-summary-box">
                            <h4 class="summary-title">Your Order</h4>

                            @forelse ($cartItems as $item)
                                @php
                                    $itemImage = $item->image && ! str_starts_with($item->image, 'http')
                                        ? asset('storage/' . ltrim($item->image, '/'))
                                        : $item->image;
                                    $itemTotal = number_format((float) $item->price * $item->quantity, 2);
                                @endphp
                                <div class="summary-item">
                                    <div class="summary-item-image">
                                        <img src="{{ $itemImage ?: 'https://via.placeholder.com/80x80?text=Item' }}"
                                             alt="{{ $item->product_name }}">
                                    </div>
                                    <div class="summary-item-info">
                                        <h6>{{ $item->product_name }}</h6>
                                        <p class="summary-item-meta">
                                            @if ($item->variant_label)
                                                {{ $item->variant_label }} |
                                            @endif
                                            Qty: {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="summary-item-price">${{ $itemTotal }}</div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">Your cart is empty.</p>
                            @endforelse

                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span class="value">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if ($coupon)
                                <div class="summary-row">
                                    <span>
                                        Coupon Discount
                                        <small class="text-success">({{ $coupon['code'] }})</small>
                                    </span>
                                    <span class="value text-success">-${{ number_format((float) ($coupon['discount_amount'] ?? 0), 2) }}</span>
                                </div>
                            @endif

                            @if ($firstOrderDiscount)
                                <div class="summary-row">
                                    <span>First Order Discount (15%)</span>
                                    <span class="value text-success">-${{ number_format((float) ($firstOrderDiscount['discount_amount'] ?? 0), 2) }}</span>
                                </div>
                            @endif

                            <div class="summary-row">
                                <span>Shipping</span>
                                <span class="value">
                                    {{ $shippingAmount > 0 ? '$' . number_format($shippingAmount, 2) : 'Free' }}
                                </span>
                            </div>

                            @if ($taxAmount > 0)
                                <div class="summary-row">
                                    <span>Tax ({{ $taxRate }}%)</span>
                                    <span class="value">${{ number_format($taxAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="summary-row total">
                                <span>Total</span>
                                <span class="value">${{ number_format($grandTotal, 2) }}</span>
                            </div>

                            <div class="summary-buttons">
                                <button id="place-order-btn" type="submit" class="btn btn-primary">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('js')
        <script>
            const checkoutForm = document.getElementById('checkout-form');
            const placeOrderButton = document.getElementById('place-order-btn');

            // Payment method active toggle
            document.querySelectorAll('.payment-option').forEach(option => {
                option.addEventListener('click', function () {
                    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    this.querySelector('input[type="radio"]').checked = true;
                });
            });

            // Ship to different address toggle
            const shippingToggle = document.getElementById('shipping_toggle');
            const shippingFields = document.getElementById('shipping-address-fields');
            const shippingField  = document.getElementById('shipping_same_as_billing_field');

            shippingToggle.addEventListener('change', function () {
                if (this.checked) {
                    shippingFields.style.display = '';
                    shippingField.value = '0';
                } else {
                    shippingFields.style.display = 'none';
                    shippingField.value = '1';
                }
            });

            function setLoadingState(isLoading) {
                placeOrderButton.disabled = isLoading;
                placeOrderButton.textContent = isLoading ? 'Processing...' : 'Place Order';
            }

            checkoutForm.addEventListener('submit', function (event) {
                // Allow normal form submission - server will handle redirect
                setLoadingState(true);
            });
        </script>
    @endpush
</x-app>
