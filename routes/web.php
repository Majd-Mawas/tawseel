<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/dashboard.php';

Route::get("/", function () {
    return view('welcome');
});
