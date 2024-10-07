<?php

use App\Http\Controllers\V1\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::resource('users', UserController::class);
