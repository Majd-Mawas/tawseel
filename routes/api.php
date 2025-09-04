<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DriverController;
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
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('cancel-order');

    // Driver routes
    Route::prefix('driver')->name('.driver')->group(function () {
        Route::get('orders/available', [DriverController::class, 'availableOrders'])->name('.available-orders');
        Route::get('orders/assigned', [DriverController::class, 'assignedOrders'])->name('.assigned-orders');
        Route::post('orders/assign', [DriverController::class, 'assignOrder'])->name('.assign-order');
        Route::put('orders/update-status', [DriverController::class, 'updateOrderStatus'])->name('.update-order-status');
        Route::get('orders/{id}', [DriverController::class, 'showOrder'])->name('.show-order');
    });
});

Route::ApiResource('centers', RestaurantController::class)->only(['index', 'show']);


Route::get('test', function () {
    return "asfd";
    return response()->json(
        'asdf'
    );
});
