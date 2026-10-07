<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pageController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\searchController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\ratingController;
use App\Http\Controllers\AiChatController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [pageController::class, 'home'])->name('home');
Route::get('/products', [pageController::class, 'product'])->name('products');
Route::get('/products/{slug}', [pageController::class, 'detail'])->name('product.detail');
Route::get('/about', [pageController::class, 'about'])->name('about');
Route::get('/search', [searchController::class, 'index'])->name('search');
Route::get('/contact', [pageController::class, 'contact'])->name('contact');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::post('/ai/chat', [AiChatController::class, 'chat'])->name('ai.chat');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // cart
    Route::get('/cart', [cartController::class, 'index'])->name('cart');
    Route::post('/cart/store', [cartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [cartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [cartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/orders', [orderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [orderController::class, 'show'])->name('orders.show');

    // checkout
    Route::get('/checkout', [checkoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [checkoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/pay/{type}/{orderId}', [checkoutController::class, 'show'])->name('checkout.pay-online');
    Route::get('/checkout/payment/result', [paymentController::class, 'vnPay'])->name('vnpay');

    Route::post('/products/{slug}/reviews', [ratingController::class, 'store'])->name('reviews.store');

    Route::post('/message/store', [MessageController::class, 'store',])->name('message.store');
    Route::get('/message/{userId}', [MessageController::class, 'conversation'])->name('message.conversation');

    Route::get('/thank-you', function () {
        return view('pages.thankyou');
    })->name('thank-you');
});

require __DIR__ . '/auth.php';
// router dành cho admin
require __DIR__ . '/admin.php';
require __DIR__ . '/api.php';
