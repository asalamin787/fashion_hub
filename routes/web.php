<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\InvoicePrintController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products', [PageController::class, 'shop'])->name('shop');
Route::get('/products/{product:slug}', [PageController::class, 'productDetails'])->name('product.details');
Route::get('/api/search-products', [PageController::class, 'searchProducts'])->name('search.products');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/blogs', [PageController::class, 'blog'])->name('blog');
Route::get('/blog-details/{blogPost:slug?}', [PageController::class, 'blogDetails'])->name('blog.details');
Route::post('/blog-details/{blogPost:slug}/comments', [PageController::class, 'storeBlogComment'])->middleware('throttle:10,1')->name('blog.comments.store');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContact'])->middleware('throttle:5,1')->name('contact.store');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])->middleware('throttle:10,1')->name('newsletter.subscribe');

Route::get('/privacy-policy', [StaticPageController::class, 'show'])->defaults('slug', 'privacy-policy')->name('privacy.policy');
Route::get('/terms-and-conditions', [StaticPageController::class, 'show'])->defaults('slug', 'terms-and-conditions')->name('terms.of.condition');
Route::get('/terms-of-condition', [StaticPageController::class, 'show'])->defaults('slug', 'terms-and-conditions');
Route::get('/cookie-policy', [StaticPageController::class, 'show'])->defaults('slug', 'cookie-policy')->name('cookie.policy');
Route::get('/returns', [StaticPageController::class, 'show'])->defaults('slug', 'returns-policy')->name('returns.policy');
Route::get('/shipping-info', [StaticPageController::class, 'show'])->defaults('slug', 'shipping-info')->name('shipping.info');
Route::get('/faq', [StaticPageController::class, 'faq'])->name('faq');
Route::get('/pages/{slug}', [StaticPageController::class, 'show'])->name('pages.show');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/{product:slug}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/item/{id}', [CartController::class, 'update'])->name('cart.item.update');
Route::delete('/cart/item/{id}', [CartController::class, 'remove'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/payment/{orderNumber}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{orderNumber}/process', [PaymentController::class, 'processStripePayment'])->name('payment.process.stripe');
Route::get('/checkout/payment/success/{orderNumber}', [PaymentController::class, 'success'])->name('checkout.payment.success');
Route::get('/checkout/payment/failed/{orderNumber}', [PaymentController::class, 'failed'])->name('checkout.payment.failed');
Route::get('/orders/{orderNumber}/confirmation', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

Route::post('/webhooks/stripe', StripeWebhookController::class)->withoutMiddleware([VerifyCsrfToken::class])->name('stripe.webhook');

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders/{order}/invoice/print', InvoicePrintController::class)->name('admin.orders.invoice.print');

    Route::prefix('account')->name('account.')->group(function (): void {
        Route::get('/', [AccountController::class, 'overview'])->name('dashboard');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderNumber}', [AccountController::class, 'orderDetails'])->name('orders.show');
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::get('/address-book', [AccountController::class, 'addressBook'])->name('address');
        Route::put('/address-book', [AccountController::class, 'updateAddress'])->name('address.update');
        Route::get('/security', [AccountController::class, 'security'])->name('security');
        Route::put('/security', [AccountController::class, 'updatePassword'])->name('security.update');
    });

    Route::post('/products/{product:slug}/reviews', [ProductReviewController::class, 'store'])
        ->name('product.reviews.store');
});
