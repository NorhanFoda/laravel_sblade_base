<?php

use App\Http\Controllers\V1\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
