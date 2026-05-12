<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProviderController;
use App\Http\Controllers\Client\ServiceRequestController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Provider\DashboardController;
use App\Http\Controllers\Provider\RequestController;
use App\Http\Controllers\Provider\ServiceController;
use App\Http\Controllers\Provider\ProfileController;
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

    // Routes Client
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/client/categories',        [HomeController::class, 'categories']);
        Route::post('/client/requests',         [ServiceRequestController::class, 'store']);
        Route::get('/client/requests',          [ServiceRequestController::class, 'index']);
        Route::delete('/client/requests/{id}',  [ServiceRequestController::class, 'destroy']);
        Route::post('/client/reviews',          [ReviewController::class, 'store']);
    });

    // Routes Prestataire
    Route::middleware(['auth:sanctum', 'role:provider'])->group(function () {
        Route::get('/provider/dashboard',                    [DashboardController::class, 'index']);
        Route::get('/provider/requests',                     [RequestController::class, 'index']);
        Route::put('/provider/requests/{id}/accept',         [RequestController::class, 'accept']);
        Route::put('/provider/requests/{id}/reject',         [RequestController::class, 'reject']);
        Route::put('/provider/requests/{id}/complete',       [RequestController::class, 'complete']);
        Route::get('/provider/services',                     [ServiceController::class, 'index']);
        Route::post('/provider/services',                    [ServiceController::class, 'store']);
        Route::put('/provider/services/{id}',                [ServiceController::class, 'update']);
        Route::delete('/provider/services/{id}',             [ServiceController::class, 'destroy']);
        Route::put('/provider/profile',                      [ProfileController::class, 'update']);
        Route::get('/provider/subscription',                 [ProfileController::class, 'subscription']);
    });

});