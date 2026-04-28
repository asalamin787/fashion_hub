<div class="offcanvas-body" style="padding: 0;">
    @php
        $cartSubtotal = (float) $cart->items->sum(fn ($cartItem) => (float) $cartItem->price * $cartItem->quantity);
    @endphp
    <div style="flex: 1; overflow-y: auto;">
        @if ($cartCount > 0)
            <div style="padding: 16px 14px 12px 14px; max-height: 488px; overflow-y: auto;">
                @foreach ($cart->items as $item)
                    @php
                        $offcanvasImage = $item->image && !str_starts_with($item->image, 'http')
                            ? asset('storage/' . ltrim($item->image, '/'))
                            : $item->image;
                        $offcanvasLineTotal = number_format((float) $item->price * $item->quantity, 2);
                    @endphp

                    <div style="display: flex; gap: 12px; padding: 12px; background: #fff; border: 1px solid #f0e6e1; border-radius: 10px; margin-bottom: 10px;">
                        <div style="width: 64px; height: 64px; border-radius: 8px; overflow: hidden; border: 1px solid #f1e9e5; flex-shrink: 0; background: #fff;">
                            <img src="{{ $offcanvasImage ?: 'https://via.placeholder.com/64x64?text=Item' }}" alt="{{ $item->product_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <div style="flex: 1; min-width: 0;">
                            <p style="margin: 0; color: #2c3e50; font-size: 14px; font-weight: 700; line-height: 1.35;">{{ $item->product_name }}</p>
                            @if (filled($item->variant_label))
                                <p style="margin: 3px 0 0 0; color: #7b6a63; font-size: 12px;">{{ $item->variant_label }}</p>
                            @endif
                            <div style="margin-top: 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                <span style="font-size: 12px; color: #6c757d;">Qty: {{ $item->quantity }}</span>
                                <span style="font-size: 13px; color: #865749; font-weight: 700;">${{ $offcanvasLineTotal }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="cart-offcanvas-empty" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; text-align: center; min-height: 300px;">
                <div class="cart-offcanvas-empty-icon" style="font-size: 64px; color: #865749; opacity: 0.6; margin-bottom: 16px;"><i class="fas fa-shopping-bag"></i></div>
                <h6 style="margin: 0 0 8px 0; color: #2c3e50; font-weight: 700; font-size: 16px;">Your cart is empty</h6>
                <p style="margin: 0; color: #666; font-size: 13px; line-height: 1.6;">Add stylish products from our collections and they will appear here.</p>
            </div>
        @endif
    </div>

    <div class="cart-offcanvas-actions" style="padding: 20px; border-top: 1px solid #eee; background: #f8f9fa;">
        @if ($cartCount > 0)
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; color: #4b4b4b; font-size: 14px; font-weight: 600;">
                <span>Subtotal</span>
                <span style="color: #865749; font-size: 16px; font-weight: 800;">${{ number_format($cartSubtotal, 2) }}</span>
            </div>
        @endif
        <a href="{{ route('cart') }}" class="btn btn-primary w-100" style="background-color: #865749; border: none; padding: 12px; font-weight: 600; border-radius: 4px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#6d3f35'" onmouseout="this.style.backgroundColor='#865749'">View Full Cart</a>
        <a href="{{ route('shop') }}" class="btn btn-outline w-100 mt-2" style="border: 2px solid #865749; color: #865749; padding: 10px; font-weight: 600; border-radius: 4px; background: white; text-decoration: none; display: block; text-align: center; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f5f0ee'" onmouseout="this.style.backgroundColor='white'">Continue Shopping</a>
    </div>
</div>