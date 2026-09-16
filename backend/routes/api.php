<?php

use App\Http\Controllers\auth\authController;
use App\Http\Controllers\category\categoryController;
use App\Http\Controllers\products\productController;
use App\Http\Middleware\auth\adminMiddleware;
use App\Http\Middleware\auth\userMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // test connect
    route::get('/', function (Request $request) {
        return response()->json([
            'message' => 'Connect successful.',
            'status' => true,
            'statusCode' => 200,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    });
    // auth routes
    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {
        Route::post('register', [authController::class, 'register']);
        Route::post('login', [authController::class, 'login']);
        Route::post('logout', [authController::class, 'logout']);
        Route::post('refresh', [authController::class, 'refresh']);
        Route::post('me', [authController::class, 'me']);
    });

    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'categories'
    ], function () {
        Route::get('/', [categoryController::class, 'index']);
        Route::get('/{id}', [categoryController::class, 'show']);

        Route::group([ 'middleware' => [adminMiddleware::class]], function () {
            Route::post('/', [categoryController::class, 'store']);
            Route::put('/{id}', [categoryController::class, 'update']);
            Route::delete('/{id}', [categoryController::class, 'destroy']);
        });
    });

    Route::group([
        'middleware' => ['api', userMiddleware::class],
        'prefix' => 'products'
    ], function () {
        Route::get('/', [productController::class, 'index']);
        Route::get('/{id}', [productController::class, 'show']);
        
        Route::group(['api' => [adminMiddleware::class]], function () {
            Route::post('/', [productController::class, 'store']);
            Route::put('/{id}', [productController::class, 'update']);
            Route::delete('/{id}', [productController::class, 'destroy']);
        });
    });
});
