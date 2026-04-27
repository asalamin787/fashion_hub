<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $ids = session('wishlist', []);

        $products = collect();

        if (! empty($ids)) {
            $products = Product::active()
                ->whereIn('id', $ids)
                ->with('category:id,name,slug')
                ->select(['id', 'name', 'slug', 'featured_image', 'base_price', 'sale_price', 'badge', 'category_id'])
                ->get();
        }

        return view('pages.wishlist', compact('products'));
    }

    public function toggle(Product $product): JsonResponse
    {
        $wishlist = session('wishlist', []);

        if (in_array($product->id, $wishlist, true)) {
            $wishlist = array_values(array_filter($wishlist, fn (int $id) => $id !== $product->id));
            $inWishlist = false;
        } else {
            $wishlist[] = $product->id;
            $inWishlist = true;
        }

        session(['wishlist' => $wishlist]);

        return response()->json([
            'in_wishlist' => $inWishlist,
            'count' => count($wishlist),
        ]);
    }
}
