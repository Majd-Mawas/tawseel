<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/api/auth.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::Apiresource('users', UserController::class);
    Route::Apiresource('meals', MealController::class);
    Route::Apiresource('orders', OrderController::class);
    Route::Apiresource('restaurants', RestaurantController::class);
    Route::Apiresource('categories', CategoryController::class);
});
