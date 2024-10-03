<?php

use App\Http\Controllers\V1\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('users', [UserController::class, 'index'])->name('users.index');
