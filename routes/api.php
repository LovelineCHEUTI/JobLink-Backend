<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProviderController;
use App\Http\Controllers\Client\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Auth — Public
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:5,1');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout',  [AuthController::class, 'logout']);
            Route::get('/me',       [AuthController::class, 'me']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
        });
    });

    // Routes publiques
    Route::get('/providers',      [ProviderController::class, 'index']);
    Route::get('/providers/{id}', [ProviderController::class, 'show']);

    // Routes protégées
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/client/categories',        [HomeController::class, 'categories']);
        Route::post('/client/requests',         [ServiceRequestController::class, 'store']);
        Route::get('/client/requests',          [ServiceRequestController::class, 'index']);
        Route::delete('/client/requests/{id}',  [ServiceRequestController::class, 'destroy']);
    });

});