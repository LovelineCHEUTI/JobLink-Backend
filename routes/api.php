<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProviderController;
use App\Http\Controllers\Client\ServiceRequestController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Provider\DashboardController as ProviderDashboard;
use App\Http\Controllers\Provider\RequestController;
use App\Http\Controllers\Provider\ServiceController;
use App\Http\Controllers\Provider\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProviderController as AdminProviderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubscriptionController;
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
        Route::get('/provider/dashboard',              [ProviderDashboard::class, 'index']);
        Route::get('/provider/requests',               [RequestController::class, 'index']);
        Route::put('/provider/requests/{id}/accept',   [RequestController::class, 'accept']);
        Route::put('/provider/requests/{id}/reject',   [RequestController::class, 'reject']);
        Route::put('/provider/requests/{id}/complete', [RequestController::class, 'complete']);
        Route::get('/provider/services',               [ServiceController::class, 'index']);
        Route::post('/provider/services',              [ServiceController::class, 'store']);
        Route::put('/provider/services/{id}',          [ServiceController::class, 'update']);
        Route::delete('/provider/services/{id}',       [ServiceController::class, 'destroy']);
        Route::put('/provider/profile',                [ProfileController::class, 'update']);
        Route::get('/provider/subscription',           [ProfileController::class, 'subscription']);
    });

    // Routes Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard',                      [AdminDashboard::class, 'index']);
        Route::get('/admin/users',                          [UserController::class, 'index']);
        Route::put('/admin/users/{id}/toggle',              [UserController::class, 'toggle']);
        Route::delete('/admin/users/{id}',                  [UserController::class, 'destroy']);
        Route::get('/admin/providers',                      [AdminProviderController::class, 'index']);
        Route::get('/admin/providers/pending',              [AdminProviderController::class, 'pending']);
        Route::put('/admin/providers/{id}/validate',        [AdminProviderController::class, 'validate']);
        Route::put('/admin/providers/{id}/toggle',          [AdminProviderController::class, 'toggle']);
        Route::get('/admin/categories',                     [CategoryController::class, 'index']);
        Route::post('/admin/categories',                    [CategoryController::class, 'store']);
        Route::put('/admin/categories/{id}',                [CategoryController::class, 'update']);
        Route::delete('/admin/categories/{id}',             [CategoryController::class, 'destroy']);
        Route::get('/admin/subscriptions',                  [SubscriptionController::class, 'index']);
        Route::post('/admin/subscriptions',                 [SubscriptionController::class, 'store']);
        Route::put('/admin/subscriptions/{id}/renew',       [SubscriptionController::class, 'renew']);
        Route::put('/admin/subscriptions/{id}/block',       [SubscriptionController::class, 'block']);
    });

});