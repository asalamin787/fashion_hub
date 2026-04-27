<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/products/{product:slug}', [PageController::class, 'productDetails'])->name('product.details');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/{product:slug}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
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
