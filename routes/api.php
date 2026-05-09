<?php

use App\Http\Controllers\TopUpController;
use App\Http\Middleware\ForceJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(ForceJson::class)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    
    Route::prefix('/game/topup')->group(function () {
        Route::post('/order', [TopUpController::class, 'createOrder']);

        Route::post('/callback/trigger', [TopUpController::class, 'triggerCallback']);

        Route::post('/callback', [TopUpController::class, 'callback']);
    });
});