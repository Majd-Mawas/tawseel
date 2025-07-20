<?php

use App\Http\Controllers\CategoryDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantDashboardController;
use App\Http\Middleware\RestaurantAdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all dashboard related routes.
| These routes are loaded by the RouteServiceProvider.
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Routes
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    // Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
    // Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');

    // // Profile Update Routes
    // Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    // Route::put('/dashboard/profile/password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.password');

    // Restaurant Management Routes (for restaurant admins only)
    Route::middleware(RestaurantAdminMiddleware::class)->group(function () {
        Route::get('/dashboard/restaurant', [RestaurantDashboardController::class, 'manage'])->name('dashboard.restaurant');
        Route::post('/dashboard/restaurant', [RestaurantDashboardController::class, 'update'])->name('dashboard.restaurant.update');

        // Meals Management Routes
        Route::get('/dashboard/meals', [MealDashboardController::class, 'index'])->name('dashboard.meals.index');
        Route::get('/dashboard/meals/create', [MealDashboardController::class, 'create'])->name('dashboard.meals.create');
        Route::post('/dashboard/meals', [MealDashboardController::class, 'store'])->name('dashboard.meals.store');
        Route::get('/dashboard/meals/{meal}/edit', [MealDashboardController::class, 'edit'])->name('dashboard.meals.edit');
        Route::post('/dashboard/meals/{meal}', [MealDashboardController::class, 'update'])->name('dashboard.meals.update');
        Route::delete('/dashboard/meals/{meal}', [MealDashboardController::class, 'destroy'])->name('dashboard.meals.destroy');

        // Categories Management Routes
        Route::get('/dashboard/categories', [CategoryDashboardController::class, 'index'])->name('dashboard.categories.index');
        Route::get('/dashboard/categories/create', [CategoryDashboardController::class, 'create'])->name('dashboard.categories.create');
        Route::post('/dashboard/categories', [CategoryDashboardController::class, 'store'])->name('dashboard.categories.store');
        Route::get('/dashboard/categories/{category}/edit', [CategoryDashboardController::class, 'edit'])->name('dashboard.categories.edit');
        Route::post('/dashboard/categories/{category}', [CategoryDashboardController::class, 'update'])->name('dashboard.categories.update');
        Route::delete('/dashboard/categories/{category}', [CategoryDashboardController::class, 'destroy'])->name('dashboard.categories.destroy');
    });
});
