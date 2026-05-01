<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/products/{product:slug}', [PageController::class, 'productDetails'])->name('product.details');
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
Route::post('/webhooks/stripe', StripeWebhookController::class)
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('stripe.webhook');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog-details/{blogPost:slug?}', [PageController::class, 'blogDetails'])->name('blog.details');
Route::post('/blog-details/{blogPost:slug}/comments', [PageController::class, 'storeBlogComment'])
    ->middleware('throttle:10,1')
    ->name('blog.comments.store');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-of-condition', [PageController::class, 'termsOfCondition'])->name('terms.of.condition');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
