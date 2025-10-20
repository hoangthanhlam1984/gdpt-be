<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::prefix('v1/users')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('{userId}', [UserController::class, 'show'])->whereNumber('userId')->name('users.show');
    Route::put('{userId}', [UserController::class, 'update'])->whereNumber('userId')->name('users.update');
    Route::delete('{userId}', [UserController::class, 'destroy'])->whereNumber('userId')->name('users.destroy');
});
