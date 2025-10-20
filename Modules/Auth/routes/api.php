<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::prefix('v1/auth/')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('me', [AuthController::class, 'me'])->name('auth.me');
    Route::put('me', [AuthController::class, 'updateProfile'])->name('auth.update_profile');
});
