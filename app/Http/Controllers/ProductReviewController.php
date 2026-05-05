<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductReviewRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(StoreProductReviewRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();
        $user = Auth::user();

        $orderItem = OrderItem::query()
            ->with('order')
            ->whereKey($validated['order_item_id'])
            ->where('product_id', $product->id)
            ->whereHas('order', fn ($query) => $query->where('user_id', $user->id))
            ->firstOrFail();

        $existingReview = ProductReview::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('order_item_id', $orderItem->id)
            ->first();

        if ($existingReview) {
            return back()->with('warning', 'You already submitted a review for this purchased item.');
        }

        $imagePaths = [];

        foreach ($request->file('images', []) as $image) {
            $imagePaths[] = $image->store('product-reviews', 'public');
        }

        ProductReview::query()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'review' => $validated['review'],
            'images' => $imagePaths === [] ? null : $imagePaths,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your review has been submitted and is awaiting approval.');
    }
}
