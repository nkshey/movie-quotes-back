<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/register', 'register')->name('auth.register');
        Route::post('/login', 'login')->name('auth.login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout')->name('auth.logout');
    });
});

Route::controller(GoogleAuthController::class)->middleware('guest')->group(function () {
    Route::get('/auth/google/redirect', 'redirect')->name('auth.google.redirect');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

Route::controller(PasswordResetController::class)->middleware('guest')->group(function () {
    Route::post('/forgot-password', 'forgotPassword')->name('password.email');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
    Route::post('/validate-reset-token', 'validateResetToken')->name('password.validate-token');
});

Route::controller(UserController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/user', 'getUser')->name('user.get');
    Route::patch('/user', 'updateUser')->name('user.update');
});

Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'verify'])
    ->name('verification.verify')
    ->middleware(['signed', 'guest']);
