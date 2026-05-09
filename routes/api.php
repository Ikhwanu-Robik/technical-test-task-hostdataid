<?php

use App\Http\Controllers\TopUpController;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(ForceJsonResponse::class)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    
    Route::prefix('/game/topup')->group(function () {
        Route::post('/order', [TopUpController::class, 'createOrder']);
    });
});