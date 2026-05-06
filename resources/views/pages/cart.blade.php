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

            @if ($firstOrderDiscount)
                <div class="alert alert-success mb-4">
                    🎉 15% First Order Discount Applied
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
                                    <tr data-cart-item-id="{{ $item->id }}">
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
                                            <form action="{{ route('cart.item.update', $item->id) }}" method="POST"
                                                class="cart-quantity-form" data-cart-item-id="{{ $item->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="cart-quantity">
                                                    <button type="button" onclick="updateQuantity(this, -1)"><i
                                                            class="fas fa-minus"></i></button>
                                                    <input type="number" value="{{ $item->quantity }}" min="1" readonly
                                                        class="cart-quantity-display">
                                                    <button type="button" onclick="updateQuantity(this, 1)"><i
                                                            class="fas fa-plus"></i></button>
                                                    <input type="hidden" name="quantity" value="{{ $item->quantity }}"
                                                        class="cart-quantity-hidden">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="cart-subtotal" data-line-subtotal>${{ $lineTotal }}</div>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.item.remove', $item->id) }}" method="POST" data-ajax-cart-remove>
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

                                <div class="cart-mobile-item" data-cart-item-id="{{ $item->id }}">
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
                                        <form action="{{ route('cart.item.update', $item->id) }}" method="POST"
                                            class="cart-quantity-form" data-cart-item-id="{{ $item->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="cart-quantity">
                                                <button type="button" onclick="updateQuantity(this, -1)"><i
                                                        class="fas fa-minus"></i></button>
                                                <input type="number" value="{{ $item->quantity }}" min="1" readonly
                                                    class="cart-quantity-display">
                                                <button type="button" onclick="updateQuantity(this, 1)"><i
                                                        class="fas fa-plus"></i></button>
                                                <input type="hidden" name="quantity" value="{{ $item->quantity }}"
                                                    class="cart-quantity-hidden">
                                            </div>
                                        </form>

                                        <div class="cart-mobile-subtotal-wrap">
                                            <span>Subtotal</span>
                                            <div class="cart-subtotal" data-line-subtotal>${{ $lineTotal }}</div>
                                        </div>

                                        <form action="{{ route('cart.item.remove', $item->id) }}" method="POST" data-ajax-cart-remove>
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
                            <div class="coupon-feedback" data-coupon-feedback></div>

                            <form class="coupon-form" method="POST" action="{{ route('cart.coupon.apply') }}"
                                data-coupon-apply-form>
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Enter coupon code"
                                    value="{{ old('coupon_code', $coupon['code'] ?? '') }}">
                                <button type="submit" class="btn btn-secondary">Apply Coupon</button>
                            </form>

                            <div class="applied-coupon-block" data-applied-coupon-block
                                style="{{ $coupon ? '' : 'display: none;' }}">
                                <span>Applied: <strong data-applied-coupon-code>{{ $coupon['code'] ?? '' }}</strong></span>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" data-coupon-remove-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm">Remove</button>
                                </form>
                            </div>
                            
                            <form action="{{ route('cart.clear') }}" method="POST" data-ajax-cart-clear>
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
                            <span class="value" data-cart-summary-subtotal>${{ number_format((float) $subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row" data-cart-summary-coupon-row style="{{ $coupon ? '' : 'display: none;' }}">
                            <span data-cart-summary-coupon-label>
                                Coupon Discount @if ($coupon)<small class="text-success">({{ $coupon['code'] }})</small>@endif
                            </span>
                            <span class="value" data-cart-summary-coupon>-${{ number_format((float) ($coupon['discount_amount'] ?? 0), 2) }}</span>
                        </div>
                        <div class="summary-row" data-cart-summary-first-order-row style="{{ $firstOrderDiscount ? '' : 'display: none;' }}">
                            <span>First Order Discount (15%)</span>
                            <span class="value" data-cart-summary-first-order>-${{ number_format((float) ($firstOrderDiscount['discount_amount'] ?? 0), 2) }}</span>
                        </div>
                        <div class="summary-row" data-cart-summary-tax-row style="{{ (float) $taxAmount > 0 ? '' : 'display: none;' }}">
                            <span data-cart-summary-tax-label>Tax ({{ number_format((float) $taxRate, 2) }}%)</span>
                            <span class="value" data-cart-summary-tax>${{ number_format((float) $taxAmount, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Items</span>
                            <span class="value" data-cart-summary-items>{{ $totalItems }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="value" data-cart-summary-total>${{ number_format((float) $total, 2) }}</span>
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
            function showCouponFeedback(message, type = 'success') {
                const feedbackEl = document.querySelector('[data-coupon-feedback]');

                if (!feedbackEl) {
                    return;
                }

                feedbackEl.textContent = message;
                feedbackEl.className = `coupon-feedback ${type}`;
                feedbackEl.style.display = 'block';

                setTimeout(() => {
                    feedbackEl.style.display = 'none';
                }, 3000);
            }

            function updateCouponState(data) {
                const couponSummaryRow = document.querySelector('[data-cart-summary-coupon-row]');
                const couponSummaryLabelEl = document.querySelector('[data-cart-summary-coupon-label]');
                const couponSummaryEl = document.querySelector('[data-cart-summary-coupon]');
                const firstOrderSummaryRow = document.querySelector('[data-cart-summary-first-order-row]');
                const firstOrderSummaryEl = document.querySelector('[data-cart-summary-first-order]');
                const taxRow = document.querySelector('[data-cart-summary-tax-row]');
                const taxEl = document.querySelector('[data-cart-summary-tax]');
                const taxLabelEl = document.querySelector('[data-cart-summary-tax-label]');
                const totalEl = document.querySelector('[data-cart-summary-total]');
                const couponBlock = document.querySelector('[data-applied-coupon-block]');
                const couponCodeEl = document.querySelector('[data-applied-coupon-code]');
                const applyForm = document.querySelector('[data-coupon-apply-form]');
                const couponInput = applyForm?.querySelector('input[name="coupon_code"]');

                const coupon = data.applied_coupon ?? null;
                const firstOrderDiscount = data.first_order_discount ?? null;
                const couponDiscountValue = parseFloat(coupon?.discount_amount ?? 0);
                const firstOrderDiscountValue = parseFloat(firstOrderDiscount?.discount_amount ?? 0);
                const taxValue = parseFloat(data.cart_tax ?? 0);
                const taxRate = data.cart_tax_rate ?? '0.00';

                if (couponSummaryRow) {
                    couponSummaryRow.style.display = couponDiscountValue > 0 ? '' : 'none';
                }

                if (couponSummaryEl) {
                    couponSummaryEl.textContent = `-$${(coupon?.discount_amount_formatted ?? '0.00')}`;
                }

                if (couponSummaryLabelEl) {
                    couponSummaryLabelEl.innerHTML = coupon
                        ? `Coupon Discount <small class="text-success">(${coupon.code})</small>`
                        : 'Coupon Discount';
                }

                if (firstOrderSummaryRow) {
                    firstOrderSummaryRow.style.display = firstOrderDiscountValue > 0 ? '' : 'none';
                }

                if (firstOrderSummaryEl) {
                    firstOrderSummaryEl.textContent = `-$${(firstOrderDiscount?.discount_amount_formatted ?? '0.00')}`;
                }

                if (taxRow) {
                    taxRow.style.display = taxValue > 0 ? '' : 'none';
                }

                if (taxEl) {
                    taxEl.textContent = `$${(data.cart_tax ?? '0.00')}`;
                }

                if (taxLabelEl) {
                    taxLabelEl.textContent = `Tax (${taxRate}%)`;
                }

                if (totalEl) {
                    totalEl.textContent = `$${(data.cart_total ?? '0.00')}`;
                }

                if (couponBlock) {
                    couponBlock.style.display = coupon ? '' : 'none';
                }

                if (couponCodeEl) {
                    couponCodeEl.textContent = coupon?.code ?? '';
                }

                if (couponInput && !couponInput.matches(':focus')) {
                    couponInput.value = coupon?.code ?? '';
                }
            }

            async function updateQuantity(button, change) {
                const wrapper = button.closest('.cart-quantity');
                const readonlyInput = wrapper.querySelector('.cart-quantity-display');
                const hiddenQuantityInput = wrapper.querySelector('.cart-quantity-hidden');
                const form = button.closest('form');
                const cartItemId = form?.dataset.cartItemId;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

                const current = parseInt(readonlyInput.value, 10) || 1;
                const next = Math.max(1, current + change);

                if (next === current || !form || !cartItemId) {
                    return;
                }

                if (form.dataset.loading === '1') {
                    return;
                }

                form.dataset.loading = '1';

                const allButtons = document.querySelectorAll(`.cart-quantity-form[data-cart-item-id="${cartItemId}"] button`);
                allButtons.forEach(btn => {
                    btn.disabled = true;
                });

                const formData = new FormData(form);
                formData.set('quantity', String(next));
                formData.set('_method', 'PATCH');

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Unable to update quantity.');
                    }

                    document.querySelectorAll(`.cart-quantity-form[data-cart-item-id="${cartItemId}"] .cart-quantity-display`).forEach(input => {
                        input.value = String(data.item_quantity);
                    });

                    document.querySelectorAll(`.cart-quantity-form[data-cart-item-id="${cartItemId}"] .cart-quantity-hidden`).forEach(input => {
                        input.value = String(data.item_quantity);
                    });

                    document.querySelectorAll(`[data-cart-item-id="${cartItemId}"] [data-line-subtotal]`).forEach(el => {
                        el.textContent = `$${data.line_subtotal}`;
                    });

                    const subtotalEl = document.querySelector('[data-cart-summary-subtotal]');
                    if (subtotalEl) {
                        subtotalEl.textContent = `$${data.cart_subtotal}`;
                    }

                    updateCouponState(data);

                    const totalItemsEl = document.querySelector('[data-cart-summary-items]');
                    if (totalItemsEl) {
                        totalItemsEl.textContent = String(data.cart_total_items ?? 0);
                    }

                    document.querySelectorAll('.cart-badge, .mobile-nav-badge').forEach(el => {
                        el.textContent = String(data.cart_count ?? 0);
                    });

                    const offcanvasContent = document.querySelector('[data-cart-offcanvas-content]');
                    if (offcanvasContent && data.cart_offcanvas_html) {
                        offcanvasContent.innerHTML = data.cart_offcanvas_html;
                    }

                    window.showToast(data.message || 'Quantity updated.', 'success');
                } catch (error) {
                    console.error('Cart quantity update failed:', error);
                    window.showToast(error.message || 'Unable to update quantity.', 'error');
                } finally {
                    form.dataset.loading = '0';
                    allButtons.forEach(btn => {
                        btn.disabled = false;
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

                async function submitCouponForm(form, method = 'POST') {
                    const formData = new FormData(form);

                    if (method === 'DELETE') {
                        formData.set('_method', 'DELETE');
                    }

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Coupon request failed.');
                    }

                    const subtotalEl = document.querySelector('[data-cart-summary-subtotal]');
                    if (subtotalEl) {
                        subtotalEl.textContent = `$${data.cart_subtotal}`;
                    }

                    const totalItemsEl = document.querySelector('[data-cart-summary-items]');
                    if (totalItemsEl) {
                        totalItemsEl.textContent = String(data.cart_total_items ?? 0);
                    }

                    document.querySelectorAll('.cart-badge, .mobile-nav-badge').forEach(el => {
                        el.textContent = String(data.cart_count ?? 0);
                    });

                    const offcanvasContent = document.querySelector('[data-cart-offcanvas-content]');
                    if (offcanvasContent && data.cart_offcanvas_html) {
                        offcanvasContent.innerHTML = data.cart_offcanvas_html;
                    }

                    updateCouponState(data);

                    return data;
                }

                document.addEventListener('submit', async function(event) {
                    const removeForm = event.target.closest('[data-ajax-cart-remove]');

                    if (!removeForm) {
                        return;
                    }

                    event.preventDefault();

                    const btn = removeForm.querySelector('button[type="submit"]');
                    if (btn) { btn.disabled = true; }

                    try {
                        const fd = new FormData(removeForm);
                        const response = await fetch(removeForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: fd,
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Unable to remove item.');
                        }

                        const row = removeForm.closest('tr[data-cart-item-id], .cart-mobile-item[data-cart-item-id]');
                        if (row) {
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }

                        document.querySelectorAll('.cart-badge, .mobile-nav-badge').forEach(el => {
                            el.textContent = String(data.cart_count ?? 0);
                        });

                        const offcanvasContent = document.querySelector('[data-cart-offcanvas-content]');
                        if (offcanvasContent && data.cart_offcanvas_html) {
                            offcanvasContent.innerHTML = data.cart_offcanvas_html;
                        }

                        updateCouponState(data);

                        const totalItemsEl = document.querySelector('[data-cart-summary-items]');
                        if (totalItemsEl) {
                            totalItemsEl.textContent = String(data.cart_total_items ?? 0);
                        }

                        const subtotalEl = document.querySelector('[data-cart-summary-subtotal]');
                        if (subtotalEl) {
                            subtotalEl.textContent = `$${data.cart_subtotal}`;
                        }

                        window.showToast(data.message || 'Item removed from cart.', 'success');
                    } catch (error) {
                        console.error('Cart remove failed:', error);
                        window.showToast(error.message || 'Unable to remove item.', 'error');
                        if (btn) { btn.disabled = false; }
                    }
                });

                document.addEventListener('submit', async function(event) {
                    const clearForm = event.target.closest('[data-ajax-cart-clear]');

                    if (!clearForm) {
                        return;
                    }

                    event.preventDefault();

                    const btn = clearForm.querySelector('button[type="submit"]');
                    if (btn) { btn.disabled = true; }

                    try {
                        const fd = new FormData(clearForm);
                        const response = await fetch(clearForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: fd,
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Unable to clear cart.');
                        }

                        document.querySelectorAll('tr[data-cart-item-id]').forEach(r => r.remove());
                        document.querySelectorAll('.cart-mobile-item[data-cart-item-id]').forEach(r => r.remove());

                        document.querySelectorAll('.cart-badge, .mobile-nav-badge').forEach(el => {
                            el.textContent = '0';
                        });

                        const offcanvasContent = document.querySelector('[data-cart-offcanvas-content]');
                        if (offcanvasContent && data.cart_offcanvas_html) {
                            offcanvasContent.innerHTML = data.cart_offcanvas_html;
                        }

                        window.showToast(data.message || 'Cart cleared.', 'success');

                        setTimeout(() => window.location.reload(), 600);
                    } catch (error) {
                        console.error('Cart clear failed:', error);
                        window.showToast(error.message || 'Unable to clear cart.', 'error');
                        if (btn) { btn.disabled = false; }
                    }
                });

                const couponApplyForm = document.querySelector('[data-coupon-apply-form]');
                if (couponApplyForm) {
                    couponApplyForm.addEventListener('submit', async function(event) {
                        event.preventDefault();

                        try {
                            const data = await submitCouponForm(this, 'POST');
                            showCouponFeedback(data.message || 'Coupon applied successfully.', 'success');
                            window.showToast(data.message || 'Coupon applied successfully.', 'success');
                        } catch (error) {
                            showCouponFeedback(error.message || 'Unable to apply coupon.', 'error');
                            window.showToast(error.message || 'Unable to apply coupon.', 'error');
                        }
                    });
                }

                document.addEventListener('submit', async function(event) {
                    const removeForm = event.target.closest('[data-coupon-remove-form]');

                    if (!removeForm) {
                        return;
                    }

                    event.preventDefault();

                    try {
                        const data = await submitCouponForm(removeForm, 'DELETE');
                        showCouponFeedback(data.message || 'Coupon removed successfully.', 'success');
                        window.showToast(data.message || 'Coupon removed successfully.', 'success');
                    } catch (error) {
                        showCouponFeedback(error.message || 'Unable to remove coupon.', 'error');
                        window.showToast(error.message || 'Unable to remove coupon.', 'error');
                    }
                });
            });
        </script>
    @endpush
</x-app>
