<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');

    // Profile Update Routes
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::put('/dashboard/profile/password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.password');
});
