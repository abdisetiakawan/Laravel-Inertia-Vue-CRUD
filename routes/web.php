<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'registerUser'])
    ->name('register.post');
