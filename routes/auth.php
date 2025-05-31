<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
    // Password Reset
    Route::get('/forgot-password', [ResetPasswordController::class, 'showPasswordResetForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthenticateController::class, 'logoutUser'])
        ->name('logout');
    // Email Verification
    Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationForm'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')
        ->name('verification.resend');
    // Confirm Password
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'showConfirmPasswordForm'])
        ->name('password.confirm');
    Route::post('/confirm-password', [ConfirmPasswordController::class, 'confirmPassword'])->middleware('throttle:6,1')
        ->name('password.confirm');
});
