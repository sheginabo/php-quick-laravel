<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BnbOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductOrderController;

Route::middleware('api')->group(function () {
    Route::get('/phpinfo', [ToolController::class, 'phpinfo']);
    Route::post('/bnbOrders', [BnbOrderController::class, 'transferOrder']);

    // User Route Group
    Route::prefix('user')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // order 只有 auth:sanctum 的使用者才能使用
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('product')->group(function () {
            Route::prefix('order')->group(function () {
                Route::get('/all', [ProductOrderController::class, 'getOrders']); // List all orders
                Route::post('/', [ProductOrderController::class, 'createOrder']); // Create a new order
                Route::middleware(['check.order.ownership'])->group(function () {
                    Route::get('/{id}', [ProductOrderController::class, 'getOrder']); // Get a specific order
                    Route::patch('/{id}', [ProductOrderController::class, 'updateOrder']); // Update a specific order
                    Route::delete('/{id}', [ProductOrderController::class, 'disableOrder']); // Delete a specific order
                });
            });
        });
    });
});
