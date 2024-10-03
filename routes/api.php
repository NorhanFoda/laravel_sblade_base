<?php
/*
use App\Http\Controllers\Api\V1\Web\Auth\LoginController;
use App\Http\Controllers\Api\V1\Web\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Web\FileController;
use App\Http\Controllers\Api\V1\Web\FilterController;
use App\Http\Controllers\Api\V1\Web\NoteController;
use App\Http\Controllers\Api\V1\Web\PermissionController;
use App\Http\Controllers\Api\V1\Web\RoleController;
use App\Http\Controllers\Api\V1\Web\UserController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('set-locale', LocalizationController::class);
Route::post('login', LoginController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });
    Route::apiResource('files', FileController::class)->except(['update', 'index']);
    Route::post('logout', LogoutController::class);
    Route::get('/filters/{model}', FilterController::class);
    Route::apiResource('notes', NoteController::class);
    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', PermissionController::class);
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/change-activation', [UserController::class, 'changeActivation']);
});
*/