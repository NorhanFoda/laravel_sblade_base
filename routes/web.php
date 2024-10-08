<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Web\HomeController;
use App\Http\Controllers\V1\Web\UserController;
use App\Http\Controllers\V1\Web\Auth\LoginController;
use App\Http\Controllers\V1\Web\Auth\LogoutController;

// -----------------------------START: Auth-----------------------------------
Route::get('/', [LoginController::class, 'getLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
// -----------------------------END: Auth-------------------------------------

Route::middleware('auth')->group(function() {
    // -----------------------------START: Home-----------------------------------
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // -----------------------------END: Home-------------------------------------

    // -----------------------------START: Users-----------------------------------
    Route::resource('users', UserController::class);
    // -----------------------------END: Users-------------------------------------
    
    Route::post('logout', LogoutController::class)->name('logout');
});
