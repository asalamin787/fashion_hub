<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>Shopping Cart</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table-wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="cart-product">
                                            <div class="cart-product-image">
                                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400"
                                                    alt="Product">
                                            </div>
                                            <div class="cart-product-info">
                                                <h5>Elegant Summer Dress</h5>
                                                <p class="cart-product-meta">Size: M | Color: Blue</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-price">$129.99</div>
                                    </td>
                                    <td>
                                        <div class="cart-quantity">
                                            <button onclick="updateQuantity(this, -1)"><i
                                                    class="fas fa-minus"></i></button>
                                            <input type="number" value="1" min="1" readonly>
                                            <button onclick="updateQuantity(this, 1)"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-subtotal">$129.99</div>
                                    </td>
                                    <td><button class="cart-remove"><i class="fas fa-times"></i></button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="cart-product">
                                            <div class="cart-product-image">
                                                <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                                    alt="Product">
                                            </div>
                                            <div class="cart-product-info">
                                                <h5>Designer Handbag</h5>
                                                <p class="cart-product-meta">Color: Brown</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-price">$199.99</div>
                                    </td>
                                    <td>
                                        <div class="cart-quantity">
                                            <button onclick="updateQuantity(this, -1)"><i
                                                    class="fas fa-minus"></i></button>
                                            <input type="number" value="1" min="1" readonly>
                                            <button onclick="updateQuantity(this, 1)"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-subtotal">$199.99</div>
                                    </td>
                                    <td><button class="cart-remove"><i class="fas fa-times"></i></button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="cart-product">
                                            <div class="cart-product-image">
                                                <img src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400"
                                                    alt="Product">
                                            </div>
                                            <div class="cart-product-info">
                                                <h5>Classic White Sneakers</h5>
                                                <p class="cart-product-meta">Size: 42</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-price">$79.99</div>
                                    </td>
                                    <td>
                                        <div class="cart-quantity">
                                            <button onclick="updateQuantity(this, -1)"><i
                                                    class="fas fa-minus"></i></button>
                                            <input type="number" value="2" min="1" readonly>
                                            <button onclick="updateQuantity(this, 1)"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-subtotal">$159.98</div>
                                    </td>
                                    <td><button class="cart-remove"><i class="fas fa-times"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-actions">
                            <form class="coupon-form">
                                <input type="text" placeholder="Enter coupon code">
                                <button type="submit" class="btn btn-secondary">Apply Coupon</button>
                            </form>
                            <a href="{{ route('shop') }}" class="btn btn-outline">Continue Shopping</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h4 class="summary-title">Cart Summary</h4>
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
                            <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            function updateQuantity(btn, change) {
                const input = btn.parentElement.querySelector('input');
                let value = parseInt(input.value) + change;
                if (value < 1) value = 1;
                input.value = value;
            }
        </script>
    @endpush
</x-app>
