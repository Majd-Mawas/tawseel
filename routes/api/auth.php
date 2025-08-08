<?php

use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

    Route::post('/register', [RegisterController::class, 'register'])->name('register');


    Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::prefix('email')->middleware('auth:sanctum')->group(function () {
        Route::get('/verify/status', [EmailVerificationController::class, 'status'])->name('verification.status');
        Route::post('/verification-notification', [EmailVerificationController::class, 'send'])->name('verification.send');
    });
});

Route::name('api.')->group(function () {
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->name('password.code');
    Route::post('/verify-reset-code', [ResetPasswordController::class, 'verifyResetCode'])->name('password.verify');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
});
