<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Retrieve the current active cart, creating one if it does not exist.
     *
     * For authenticated users the cart is keyed by user_id.
     * For guests it is keyed by the session ID.
     */
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'active'],
                ['session_id' => null],
            );
        }

        $guestCart = Cart::firstOrCreate(
            ['session_id' => session()->getId(), 'status' => 'active', 'user_id' => null],
        );

        session(['guest_cart_id' => $guestCart->id]);

        return $guestCart;
    }

    /**
     * Add a product (optionally a specific variant) to the cart.
     *
     * When the product has variants, pass the variant identifier via $variantId.
     * If the same product+variant already exists in the cart, the quantity
     * is increased instead of creating a duplicate row.
     *
     * @throws \RuntimeException when the product or variant is inactive/unavailable.
     * @throws \RuntimeException when stock is insufficient.
     */
    public function addToCart(int $productId, ?string $variantId = null, int $quantity = 1): CartItem
    {
        $product = Product::active()->find($productId);

        if (! $product) {
            throw new \RuntimeException('Product is not available.');
        }

        [$price, $stock, $sku, $image, $variantLabel] = $this->resolveProductData($product, $variantId);

        return DB::transaction(function () use ($product, $variantId, $quantity, $price, $stock, $sku, $image, $variantLabel): CartItem {
            $cart = $this->getCart();

            $existing = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->where(function ($query) use ($variantId): void {
                    if ($variantId === null) {
                        $query->whereNull('product_variant_id');
                    } else {
                        $query->where('product_variant_id', $variantId);
                    }
                })
                ->lockForUpdate()
                ->first();

            $newQuantity = ($existing?->quantity ?? 0) + $quantity;

            if ($newQuantity > $stock) {
                throw new \RuntimeException("Only {$stock} item(s) available in stock.");
            }

            if ($existing) {
                $existing->update(['quantity' => $newQuantity]);

                return $existing->fresh();
            }

            return CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'product_name' => $product->name,
                'variant_label' => $variantLabel,
                'sku' => $sku,
                'price' => $price,
                'image' => $image,
            ]);
        });
    }

    /**
     * Update the quantity of an existing cart item.
     *
     * @throws \RuntimeException when the item does not belong to the current cart.
     * @throws \RuntimeException when stock is insufficient.
     */
    public function updateQuantity(int $cartItemId, int $quantity): CartItem
    {
        return DB::transaction(function () use ($cartItemId, $quantity): CartItem {
            $cart = $this->getCart();

            $item = CartItem::where('id', $cartItemId)
                ->where('cart_id', $cart->id)
                ->lockForUpdate()
                ->firstOrFail();

            $product = Product::active()->find($item->product_id);

            if (! $product) {
                throw new \RuntimeException('Product is no longer available.');
            }

            [, $stock] = $this->resolveProductData($product, $item->product_variant_id);

            if ($quantity > $stock) {
                throw new \RuntimeException("Only {$stock} item(s) available in stock.");
            }

            $item->update(['quantity' => $quantity]);

            return $item->fresh();
        });
    }

    /**
     * Remove a single item from the cart.
     *
     * @throws \RuntimeException when the item does not belong to the current cart.
     */
    public function removeItem(int $cartItemId): void
    {
        $cart = $this->getCart();

        CartItem::where('id', $cartItemId)
            ->where('cart_id', $cart->id)
            ->firstOrFail()
            ->delete();
    }

    /**
     * Remove all items from the current cart.
     */
    public function clearCart(): void
    {
        $this->getCart()->items()->delete();
    }

    /**
     * Return the formatted subtotal for all items in the current cart.
     */
    public function getSubtotal(): string
    {
        $total = $this->getCart()
            ->items()
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total') ?? 0;

        return number_format((float) $total, 2, '.', '');
    }

    /**
     * Return the total number of individual items (sum of quantities).
     */
    public function getTotalItems(): int
    {
        return (int) $this->getCart()->items()->sum('quantity');
    }

    /**
     * Merge the guest session cart into the authenticated user's cart after login.
     *
     * Called from the Login event listener. Items that already exist in the user
     * cart have their quantities combined, capped at available stock.
     */
    public function mergeGuestCartToUserCart(): void
    {
        if (! Auth::check()) {
            return;
        }

        $guestCartId = session('guest_cart_id');

        $guestCart = Cart::active()->whereNull('user_id')->where('id', $guestCartId)->with('items')->first();

        if (! $guestCart) {
            $guestCart = Cart::active()
                ->whereNull('user_id')
                ->where('session_id', session()->getId())
                ->with('items')
                ->first();
        }

        if (! $guestCart || $guestCart->items->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($guestCart): void {
            $userCart = Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'active'],
                ['session_id' => null],
            );

            foreach ($guestCart->items as $guestItem) {
                $product = Product::active()->find($guestItem->product_id);

                if (! $product) {
                    continue;
                }

                try {
                    [, $stock] = $this->resolveProductData($product, $guestItem->product_variant_id);
                } catch (\RuntimeException) {
                    continue;
                }

                $userItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $guestItem->product_id)
                    ->where(function ($query) use ($guestItem): void {
                        if ($guestItem->product_variant_id === null) {
                            $query->whereNull('product_variant_id');
                        } else {
                            $query->where('product_variant_id', $guestItem->product_variant_id);
                        }
                    })
                    ->lockForUpdate()
                    ->first();

                if ($userItem) {
                    $userItem->update(['quantity' => min($userItem->quantity + $guestItem->quantity, $stock)]);
                } else {
                    $guestItem->replicate()->fill(['cart_id' => $userCart->id])->save();
                }
            }

            $guestCart->update(['status' => 'merged']);
            session()->forget('guest_cart_id');
        });
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve price, stock, sku, image, and variant label from a product row.
     *
     * @return array{0: float, 1: int, 2: string|null, 3: string|null, 4: string|null}
     *
     * @throws \RuntimeException
     */
    private function resolveProductData(Product $product, ?string $variantId): array
    {
        if ((bool) $product->has_variants && blank($variantId)) {
            throw new \RuntimeException('Please select a product variant.');
        }

        if ($variantId !== null) {
            $variant = collect($product->variants ?? [])
                ->first(fn (mixed $v): bool => is_array($v) && (string) ($v['sku'] ?? '') === $variantId);

            if (! $variant) {
                throw new \RuntimeException('Variant not found for this product.');
            }

            if (($variant['status'] ?? 'active') !== 'active') {
                throw new \RuntimeException('This variant is currently unavailable.');
            }

            $stock = (int) ($variant['stock'] ?? 0);

            $price = isset($variant['sale_price']) && (float) $variant['sale_price'] > 0
                ? (float) $variant['sale_price']
                : (float) ($variant['price'] ?? 0);

            $sku = $variant['sku'] ?? null;
            $image = $variant['image'] ?? $product->featured_image ?? null;
            $variantLabel = Product::formatVariantLabel($variant);

            return [$price, $stock, $sku, $image, $variantLabel];
        }

        $stock = (int) ($product->stock ?? 0);

        $price = ($product->sale_price && (float) $product->sale_price > 0)
            ? (float) $product->sale_price
            : (float) ($product->base_price ?? 0);

        return [$price, $stock, null, $product->featured_image ?? null, null];
    }
}
