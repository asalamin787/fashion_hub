<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart()->load('items.product');

        return view('pages.cart', [
            'cart' => $cart,
            'subtotal' => $this->cartService->getSubtotal(),
            'totalItems' => $this->cartService->getTotalItems(),
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
                $cart = $this->cartService->getCart()->load('items.product');
                $cartCount = (int) $cart->items->sum('quantity');

                return response()->json([
                    'message' => 'Product added to cart.',
                    'product_id' => $productId,
                    'cart_count' => $cartCount,
                    'wishlist_count' => count($request->session()->get('wishlist', [])),
                    'removed_from_wishlist' => $wasInWishlist,
                    'cart_offcanvas_html' => view('components.cart-offcanvas-content', [
                        'cart' => $cart,
                        'cartCount' => $cartCount,
                    ])->render(),
                ]);
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

    public function update(UpdateCartItemRequest $request, int $id): RedirectResponse
    {
        try {
            $this->cartService->updateQuantity($id, (int) $request->validated('quantity'));

            return back()->with('success', 'Cart quantity updated.');
        } catch (\Throwable $exception) {
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
}
