<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Dashboard\NotificationController;

use App\Http\Controllers\V1\Web\HomeController;
use App\Http\Controllers\V1\Web\RoleController;
use App\Http\Controllers\V1\Web\UserController;
use App\Http\Controllers\V1\Web\Auth\LoginController;
use App\Http\Controllers\V1\Web\PermissionController;
use App\Http\Controllers\V1\Web\Auth\LogoutController;

// -----------------------------START: Auth-----------------------------------
Route::get('/', [LoginController::class, 'getLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
// -----------------------------END: Auth-------------------------------------

Route::middleware('auth:web')->group(function() {
    // -----------------------------START: Home-----------------------------------
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // -----------------------------END: Home-------------------------------------

    // -----------------------------START: Users-----------------------------------
    Route::resource('users', UserController::class);
    // -----------------------------END: Users-------------------------------------

    // -----------------------------START: Roles-----------------------------------
    Route::resource('roles', RoleController::class);
    Route::get('permissions', PermissionController::class);
    // -----------------------------END: Roles-------------------------------------

    Route::post('logout', LogoutController::class)->name('logout');
});


Route::resource('notifications', NotificationController::class);
