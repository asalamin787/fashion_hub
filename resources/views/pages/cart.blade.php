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
            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table-wrapper">
                        <table class="cart-table cart-table-desktop">
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
                                @forelse ($cart->items as $item)
                                    @php
                                        $lineTotal = number_format((float) $item->price * $item->quantity, 2);
                                        $image = $item->image && !str_starts_with($item->image, 'http')
                                            ? asset('storage/' . ltrim($item->image, '/'))
                                            : $item->image;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="cart-product">
                                                <div class="cart-product-image">
                                                    <img src="{{ $image ?: 'https://via.placeholder.com/120x120?text=Item' }}"
                                                        alt="{{ $item->product_name }}">
                                                </div>
                                                <div class="cart-product-info">
                                                    <h5>{{ $item->product_name }}</h5>
                                                    @if (filled($item->variant_label))
                                                        <p class="cart-product-meta">Variant: {{ $item->variant_label }}</p>
                                                    @endif
                                                    @if (filled($item->sku))
                                                        <p class="cart-product-meta">SKU: {{ $item->sku }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cart-price">${{ number_format((float) $item->price, 2) }}</div>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.item.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="cart-quantity">
                                                    <button type="button" onclick="updateQuantity(this, -1)"><i
                                                            class="fas fa-minus"></i></button>
                                                    <input type="number" value="{{ $item->quantity }}" min="1" readonly>
                                                    <button type="button" onclick="updateQuantity(this, 1)"><i
                                                            class="fas fa-plus"></i></button>
                                                    <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="cart-subtotal">${{ $lineTotal }}</div>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.item.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="cart-remove" type="submit" aria-label="Remove item">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 60px 20px; background: linear-gradient(135deg, rgba(134, 87, 73, 0.05) 0%, rgba(134, 87, 73, 0.08) 100%);">
                                            <div style="max-width: 400px; margin: 0 auto;">
                                                <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.6; color: #865749;">
                                                    <i class="fas fa-shopping-bag"></i>
                                                </div>
                                                <h3 style="margin: 0 0 12px 0; font-size: 20px; font-weight: 700; color: #2c3e50;">Your Cart is Empty</h3>
                                                <p style="margin: 0 0 24px 0; color: #666; font-size: 14px; line-height: 1.6;">Looks like you haven't added anything to your cart yet. Start exploring our amazing collection of fashion items!</p>
                                                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                                                    <a href="{{ route('shop') }}" class="btn btn-primary" style="text-decoration: none; background-color: #865749; color: white; padding: 12px 28px; border-radius: 4px; font-weight: 600; transition: background-color 0.2s; display: inline-block; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#6d3f35'" onmouseout="this.style.backgroundColor='#865749'">Continue Shopping</a>
                                                    <a href="{{ route('home') }}" class="btn btn-outline" style="text-decoration: none; background-color: white; color: #865749; padding: 12px 28px; border-radius: 4px; font-weight: 600; border: 2px solid #865749; transition: all 0.2s; display: inline-block; cursor: pointer;" onmouseover="this.style.backgroundColor='#f5f0ee'" onmouseout="this.style.backgroundColor='white'">Browse Home</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="cart-mobile-list">
                            @foreach ($cart->items as $item)
                                @php
                                    $lineTotal = number_format((float) $item->price * $item->quantity, 2);
                                    $image = $item->image && !str_starts_with($item->image, 'http')
                                        ? asset('storage/' . ltrim($item->image, '/'))
                                        : $item->image;
                                @endphp

                                <div class="cart-mobile-item">
                                    <div class="cart-mobile-top">
                                        <div class="cart-product-image">
                                            <img src="{{ $image ?: 'https://via.placeholder.com/120x120?text=Item' }}"
                                                alt="{{ $item->product_name }}">
                                        </div>
                                        <div class="cart-mobile-info">
                                            <h5>{{ $item->product_name }}</h5>
                                            @if (filled($item->variant_label))
                                                <p class="cart-product-meta">Variant: {{ $item->variant_label }}</p>
                                            @endif
                                            @if (filled($item->sku))
                                                <p class="cart-product-meta">SKU: {{ $item->sku }}</p>
                                            @endif
                                            <div class="cart-price">${{ number_format((float) $item->price, 2) }}</div>
                                        </div>
                                    </div>

                                    <div class="cart-mobile-bottom">
                                        <form action="{{ route('cart.item.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="cart-quantity">
                                                <button type="button" onclick="updateQuantity(this, -1)"><i
                                                        class="fas fa-minus"></i></button>
                                                <input type="number" value="{{ $item->quantity }}" min="1" readonly>
                                                <button type="button" onclick="updateQuantity(this, 1)"><i
                                                        class="fas fa-plus"></i></button>
                                                <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                                            </div>
                                        </form>

                                        <div class="cart-mobile-subtotal-wrap">
                                            <span>Subtotal</span>
                                            <div class="cart-subtotal">${{ $lineTotal }}</div>
                                        </div>

                                        <form action="{{ route('cart.item.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="cart-remove" type="submit" aria-label="Remove item">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="cart-actions">
                            <form class="coupon-form" method="POST">
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Enter coupon code" value="{{ old('coupon_code') }}">
                                <button type="submit" class="btn btn-secondary">Apply Coupon</button>
                            </form>
                            
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary w-100">Clear Cart</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h4 class="summary-title">Cart Summary</h4>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="value">${{ number_format((float) $subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Items</span>
                            <span class="value">{{ $totalItems }}</span>
                        </div>
                        <div class="summary-buttons">
                            <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                        <div class="summary-buttons">
                            <a href="{{ route('shop') }}" class="btn btn-outline">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            function updateQuantity(button, change) {
                const wrapper = button.closest('.cart-quantity');
                const readonlyInput = wrapper.querySelector('input[type="number"]');
                const hiddenQuantityInput = wrapper.querySelector('input[type="hidden"][name="quantity"]');
                const form = button.closest('form');

                const current = parseInt(readonlyInput.value, 10) || 1;
                const next = Math.max(1, current + change);

                if (next === current) {
                    return;
                }

                readonlyInput.value = String(next);
                hiddenQuantityInput.value = String(next);
                form.submit();
            }
        </script>
    @endpush
</x-app>
