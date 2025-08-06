<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register')->name('auth.register');
        Route::post('/login', 'login')->name('auth.login');
    });

    Route::controller(GoogleAuthController::class)->group(function () {
        Route::get('/auth/google/redirect', 'redirect')->name('auth.google.redirect');
        Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
    });

    Route::controller(PasswordResetController::class)->group(function () {
        Route::post('/forgot-password', 'forgotPassword')->name('password.email');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
        Route::post('/validate-reset-token', 'validateResetToken')->name('password.validate-token');
    });

    Route::controller(EmailController::class)->group(function () {
        Route::get('/email/verify/{id}/{hash}', 'verify')
            ->name('verification.verify')
            ->middleware('signed');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('auth.logout');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'show')->name('user.show');
        Route::patch('/user', 'update')->name('user.update');
    });

    Route::controller(GenreController::class)->group(function () {
        Route::get('/genres', 'index')->name('genres.index');
    });

    Route::controller(MovieController::class)->group(function () {
        Route::get('/movies', 'index')->name('movies.index');
        Route::get('/movies/{movie}', 'show')->name('movies.show');
        Route::post('/movies', 'store')->name('movies.store');
        Route::patch('/movies/{movie}', 'update')->name('movies.update');
        Route::delete('/movies/{movie}', 'destroy')->name('movies.destroy');
    });

    Route::controller(QuoteController::class)->group(function () {
        Route::post('/quotes', 'store')->name('quotes.store');
        Route::patch('/quotes/{quote}', 'update')->name('quotes.update');
        Route::delete('/quotes/{quote}', 'destroy')->name('quotes.destroy');
    });
});
