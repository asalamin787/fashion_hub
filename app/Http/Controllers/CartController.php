<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart()->load('items.product');
        $totals = $this->cartService->getCartTotals();

        return view('pages.cart', [
            'cart' => $cart,
            'subtotal' => $totals['subtotal'],
            'discount' => $totals['discount'],
            'taxAmount' => $totals['tax'],
            'taxRate' => $totals['tax_rate'],
            'total' => $totals['total'],
            'totalItems' => $totals['total_items'],
            'coupon' => $totals['coupon'],
        ]);
    }

    public function add(AddToCartRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $validated = $request->validated();
            $productId = (int) $validated['product_id'];
            $wishlist = $request->session()->get('wishlist', []);
            $wasInWishlist = in_array($productId, $wishlist, true);

            $this->cartService->addToCart(
                productId: $productId,
                variantId: $validated['product_variant_id'] ?? null,
                quantity: (int) ($validated['quantity'] ?? 1),
            );

            $request->session()->put(
                'wishlist',
                array_values(array_filter(
                    $wishlist,
                    fn (int $id): bool => $id !== $productId,
                )),
            );

            if ($request->expectsJson()) {
                return response()->json(array_merge([
                    'message' => 'Product added to cart.',
                    'product_id' => $productId,
                    'wishlist_count' => count($request->session()->get('wishlist', [])),
                    'removed_from_wishlist' => $wasInWishlist,
                ], $this->buildCartUiPayload()));
            }

            return back()->with('success', 'Product added to cart.');
        } catch (\RuntimeException $exception) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $exception->getMessage(),
                ], 422);
            }

            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function update(UpdateCartItemRequest $request, int $id): RedirectResponse|JsonResponse
    {
        try {
            $quantity = (int) $request->validated('quantity');
            $this->cartService->updateQuantity($id, $quantity);

            if ($request->expectsJson()) {
                $cart = $this->cartService->getCart()->load('items.product');
                $updatedItem = $cart->items->firstWhere('id', $id);

                if (! $updatedItem) {
                    return response()->json([
                        'message' => 'Cart item not found.',
                    ], 404);
                }

                return response()->json(array_merge([
                    'message' => 'Cart quantity updated.',
                    'item_id' => $id,
                    'item_quantity' => (int) $updatedItem->quantity,
                    'line_subtotal' => number_format((float) $updatedItem->price * $updatedItem->quantity, 2),
                ], $this->buildCartUiPayload($cart)));
            }

            return back()->with('success', 'Cart quantity updated.');
        } catch (\Throwable $exception) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unable to update cart item.',
                ], 422);
            }

            return back()->withInput()->with('error', 'Unable to update cart item.');
        }
    }

    public function remove(int $id): RedirectResponse
    {
        try {
            $this->cartService->removeItem($id);

            return back()->with('success', 'Item removed from cart.');
        } catch (\Throwable) {
            return back()->with('error', 'Unable to remove cart item.');
        }
    }

    public function clear(): RedirectResponse
    {
        $this->cartService->clearCart();

        return back()->with('success', 'Cart cleared.');
    }

    public function applyCoupon(ApplyCouponRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $validated = $request->validated();
            $this->cartService->applyCoupon($validated['coupon_code']);

            if ($request->expectsJson()) {
                return response()->json(array_merge([
                    'message' => 'Coupon applied successfully.',
                    'coupon_code' => $validated['coupon_code'],
                ], $this->buildCartUiPayload()));
            }

            return back()->with('success', 'Coupon applied successfully.');
        } catch (\RuntimeException $exception) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $exception->getMessage(),
                ], 422);
            }

            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function removeCoupon(Request $request): RedirectResponse|JsonResponse
    {
        $this->cartService->removeCoupon();

        if ($request->expectsJson()) {
            return response()->json(array_merge([
                'message' => 'Coupon removed successfully.',
            ], $this->buildCartUiPayload()));
        }

        return back()->with('success', 'Coupon removed successfully.');
    }

    /**
     * @param  Cart|null  $cart
     * @return array<string, mixed>
     */
    private function buildCartUiPayload($cart = null): array
    {
        $activeCart = $cart?->loadMissing('items.product') ?? $this->cartService->getCart()->load('items.product');
        $cartCount = (int) $activeCart->items->sum('quantity');
        $totals = $this->cartService->getCartTotals();

        return [
            'cart_count' => $cartCount,
            'cart_total_items' => (int) $totals['total_items'],
            'cart_subtotal' => number_format((float) $totals['subtotal'], 2, '.', ''),
            'cart_discount' => number_format((float) $totals['discount'], 2, '.', ''),
            'cart_tax' => number_format((float) $totals['tax'], 2, '.', ''),
            'cart_tax_rate' => number_format((float) $totals['tax_rate'], 2, '.', ''),
            'cart_total' => number_format((float) $totals['total'], 2, '.', ''),
            'applied_coupon' => $totals['coupon'],
            'cart_offcanvas_html' => view('components.cart-offcanvas-content', [
                'cart' => $activeCart,
                'cartCount' => $cartCount,
            ])->render(),
        ];
    }
}
