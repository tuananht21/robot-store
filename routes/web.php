<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\admin\categoryController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\detailProductController;
use App\Http\Controllers\admin\inStockController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Middleware\roleMiddleware;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [pageController::class, 'home'])->name('home');
Route::get('/products', [pageController::class, 'product'])->name('products');
Route::get('/products/{slug}', [pageController::class, 'detail'])->name('product.detail');
Route::get('/about', [pageController::class, 'about'])->name('about');
Route::get('/contact', [pageController::class, 'contact'])->name('contact');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', roleMiddleware::class])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    // categories
    Route::get('/categories', [categoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [categoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [categoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{slug}', [categoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{slug}/edit', [categoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{slug}', [categoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{slug}', [categoryController::class, 'destroy'])->name('categories.destroy');

    // products
    Route::get('/products', [productController::class, 'index'])->name('products.index');
    Route::post('/products/search', [productController::class, 'index'])->name('products.search');
    Route::get('/products/create', [productController::class, 'create'])->name('products.create');
    Route::post('/products', [productController::class, 'store'])->name('products.store');
    Route::get('/products/{slug}', [productController::class, 'show'])->name('products.show');
    Route::get('/products/{slug}/edit', [productController::class, 'edit'])->name('products.edit');
    Route::put('/products/{slug}', [productController::class, 'update'])->name('products.update');
    Route::delete('/products/{slug}', [productController::class, 'destroy'])->name('products.destroy');
    
    Route::get('/products/{product}/detail-products', [detailProductController::class, 'index'])->name('products.detail-products.index');
    Route::get('/products/{product}/detail-products/create', [detailProductController::class, 'create'])->name('products.detail-products.create');
    Route::post('/products/{product}/detail-products', [detailProductController::class, 'store'])->name('products.detail-products.store');
    Route::get('/products/{product}/detail-products/{detailProduct}/edit', [detailProductController::class, 'edit'])->name('products.detail-products.edit');
    Route::put('/products/{product}/detail-products/{detailProduct}', [detailProductController::class, 'update'])->name('products.detail-products.update');
    Route::delete('/products/{product}/detail-products/{detailProduct}', [detailProductController::class, 'destroy'])->name('products.detail-products.destroy');

    Route::get('/detail-products/{detailID}/in-stock', [inStockController::class, 'index'])->name('detail-products.in-stock.index');
    Route::put('/detail-products/{detailID}/in-stock', [inStockController::class, 'update'])->name('detail-products.in-stock.update');

    // orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
});

require __DIR__ . '/auth.php';
