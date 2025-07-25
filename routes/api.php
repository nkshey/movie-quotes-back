<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
    });
});

Route::controller(GoogleAuthController::class)->middleware('guest')->group(function () {
    Route::get('/auth/google/redirect', 'redirect');
    Route::get('/auth/google/callback', 'callback');
});

Route::controller(PasswordResetController::class)->middleware('guest')->group(function () {
    Route::post('/forgot-password', 'forgotPassword')->name('password.email');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
    Route::post('/validate-reset-token', 'validateResetToken');
});

Route::controller(UserController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/user', 'getUser');
    Route::patch('/user', 'updateUser');
});

Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'verify'])
    ->name('verification.verify')
    ->middleware(['signed', 'guest']);
