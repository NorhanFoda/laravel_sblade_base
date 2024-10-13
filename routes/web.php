<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Dashboard\HomeController;
use App\Http\Controllers\V1\Dashboard\RoleController;
use App\Http\Controllers\V1\Dashboard\UserController;
use App\Http\Controllers\V1\Dashboard\Auth\LoginController;
use App\Http\Controllers\V1\Dashboard\PermissionController;
use App\Http\Controllers\V1\Dashboard\Auth\LogoutController;

// -----------------------------START: Auth-----------------------------------
Route::get('/', [LoginController::class, 'getLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:web')->group(function() {
    // -----------------------------START: Home-----------------------------------
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // -----------------------------START: Users-----------------------------------
    Route::resource('users', UserController::class);
    // -----------------------------START: Roles-----------------------------------
    Route::resource('roles', RoleController::class);
    Route::get('permissions', PermissionController::class);

    Route::post('logout', LogoutController::class)->name('logout');
});
