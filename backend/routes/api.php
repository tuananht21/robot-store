<?php

use App\Http\Controllers\auth\authController;
use App\Http\Controllers\category\categoryController;
use App\Http\Controllers\products\productController;
use App\Http\Controllers\detailProduct\detailProductController;
use App\Http\Controllers\image\imageController;
use App\Http\Controllers\cart\cartController;
use App\Http\Controllers\order\orderController;
use App\Http\Middleware\auth\adminMiddleware;
use App\Http\Middleware\auth\userMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Test connect
    Route::get('/', function (Request $request) {
        return response()->json([
            'message' => 'Connect successful.',
            'status' => true,
            'statusCode' => 200,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    });

    // Auth routes
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function () {
        Route::post('register', [authController::class, 'register']);
        Route::post('login', [authController::class, 'login']);
        Route::post('logout', [authController::class, 'logout']);
        Route::post('refresh', [authController::class, 'refresh']);
        Route::post('me', [authController::class, 'me']);
    });

    // Categories
    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'categories'
    ], function () {
        // User
        Route::get('/', [categoryController::class, 'index']);
        Route::get('/{id}', [categoryController::class, 'show']);

        // Admin
        Route::group([
            'middleware' => adminMiddleware::class
        ], function () {
            Route::post('/', [categoryController::class, 'store']);
            Route::put('/{id}', [categoryController::class, 'update']);
            Route::delete('/{id}', [categoryController::class, 'destroy']);
        });
    });

    // Products
    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'products'
    ], function () {
        // User
        Route::get('/', [productController::class, 'index']);
        Route::get('/{id}', [productController::class, 'show']);

        // Admin
        Route::group([
            'middleware' => adminMiddleware::class
        ], function () {
            Route::post('/', [productController::class, 'store']);
            Route::put('/{id}', [productController::class, 'update']);
            Route::delete('/{id}', [productController::class, 'destroy']);
        });
    });

    // Detail Products (Variants)
    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'detail-products'
    ], function () {
        // User
        Route::get('/', [detailProductController::class, 'index']);
        Route::get('/product/{productId}', [detailProductController::class, 'getByProduct']);
        Route::get('/{id}', [detailProductController::class, 'show']);

        // Admin
        Route::group([
            'middleware' => adminMiddleware::class
        ], function () {
            Route::post('/', [detailProductController::class, 'store']);
            Route::put('/{id}', [detailProductController::class, 'update']);
            Route::delete('/{id}', [detailProductController::class, 'destroy']);
        });
    });

    // Product Images
    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'images'
    ], function () {
        // User
        Route::get('/', [imageController::class, 'index']);
        Route::get('/product/{productId}', [imageController::class, 'getByProduct']);
        Route::get('/{id}', [imageController::class, 'show']);

        // Admin
        Route::group([
            'middleware' => adminMiddleware::class
        ], function () {
            Route::post('/', [imageController::class, 'store']);
            Route::delete('/{id}', [imageController::class, 'destroy']);
        });
    });

    // Carts
    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'carts'
    ], function () {
        Route::get('/', [cartController::class, 'index']);
        Route::post('/', [cartController::class, 'store']);
        Route::put('/{id}', [cartController::class, 'update']);
        Route::delete('/clear', [cartController::class, 'clear']);
        Route::delete('/{id}', [cartController::class, 'destroy']);
    });

    // Orders
    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'orders'
    ], function () {
        // User
        Route::get('/', [orderController::class, 'index']);
        Route::get('/{id}', [orderController::class, 'show']);
        Route::post('/', [orderController::class, 'store']);

        // Admin
        Route::group([
            'middleware' => adminMiddleware::class
        ], function () {
            Route::get('/admin/all', [orderController::class, 'adminIndex']);
            Route::put('/{id}/status', [orderController::class, 'updateStatus'])->name('admin.orders.status');
        });
    });
});
