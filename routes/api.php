<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BnbOrderController;
use App\Http\Controllers\AuthController;

Route::middleware('api')->group(function () {
    Route::get('/phpinfo', [ToolController::class, 'phpinfo']);
    Route::post('/bnbOrders', [BnbOrderController::class, 'transferOrder']);

    // User Route Group
    Route::prefix('user')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });
});
