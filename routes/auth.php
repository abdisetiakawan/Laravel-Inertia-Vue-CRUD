<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'registerUser'])
        ->name('register.post');
    // Login
    Route::get('/login', [AuthenticateController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login', [AuthenticateController::class, 'loginUser'])
        ->name('login.post');
});
