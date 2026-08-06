<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\BrandController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\ProductImageController;
use App\Http\Controllers\StorefrontController;

Route::get('/', [StorefrontController::class, 'index'])->name('home');

Route::get('/shop', [StorefrontController::class, 'shop'])->name('storefront.shop');
Route::get('/products/{product:slug}', [StorefrontController::class, 'show'])->name('storefront.product');
Route::get('/cart', [StorefrontController::class, 'cart'])->name('storefront.cart');
Route::post('/cart/add/{product}', [StorefrontController::class, 'addToCart'])->name('storefront.cart.add');
Route::post('/cart/remove/{cart}', [StorefrontController::class, 'removeFromCart'])->name('storefront.cart.remove');
Route::get('/checkout', [StorefrontController::class, 'checkoutPage'])->name('storefront.checkout');
Route::post('/checkout', [StorefrontController::class, 'checkout'])->name('storefront.checkout.submit');
Route::get('/account', [StorefrontController::class, 'account'])->name('storefront.account');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('categories', CategoryController::class)
        ->except(['show']);
    Route::resource('brands', BrandController::class)
        ->except(['show']);
    Route::resource('products', ProductController::class)
        ->except(['show']);
    Route::resource('product-images', ProductImageController::class)
        ->except(['show']);
    Route::resource('orders', \App\Http\Controllers\OrderController::class)->except(['show']);
    Route::resource('order-items', \App\Http\Controllers\OrderItemController::class)->except(['show']);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class)->except(['show']);
    Route::resource('customer-addresses', \App\Http\Controllers\CustomerAddressController::class)->except(['show']);
    Route::resource('carts', \App\Http\Controllers\CartController::class)->except(['show']);
    Route::resource('wishlists', \App\Http\Controllers\WishlistController::class)->except(['show']);
    Route::resource('coupons', \App\Http\Controllers\CouponController::class)->except(['show']);
    Route::resource('payments', \App\Http\Controllers\PaymentController::class)->except(['show']);
    Route::resource('reviews', \App\Http\Controllers\ReviewController::class)->except(['show']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/settings.php';
