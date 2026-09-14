<?php

use App\Http\Controllers\auth\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // test connect
    route::get('/', function (Request $request) {
        return response()->json([
            'message' => 'Connect successfull.',
            'status' => true,
            'statusCode' => 200,
        ], JSON_UNESCAPED_UNICODE);
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
});
