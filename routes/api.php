<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\OrderController;

Route::middleware('api')->group(function () {
    Route::get('/phpinfo', [ToolController::class, 'phpinfo']);
    Route::get('/rawSQL', [ToolController::class, 'rawSQL']);
    Route::post('/orders', [OrderController::class, 'transferOrder']);
});
