<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;




require __DIR__ . '/api/auth.php';

Route::middleware('auth:sanctum')->name('api')->group(function () {
    Route::ApiResource('users', UserController::class);
    Route::ApiResource('meals', MealController::class);
    Route::ApiResource('orders', OrderController::class);
    Route::ApiResource('restaurants', RestaurantController::class);
    Route::ApiResource('categories', CategoryController::class);

    Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');
});

Route::ApiResource('centers', RestaurantController::class)->only(['index', 'show']);


Route::get('test', function () {
    return "asfd";
    return response()->json(
        'asdf'
    );
});
