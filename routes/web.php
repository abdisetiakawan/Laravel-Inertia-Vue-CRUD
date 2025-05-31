<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->middleware('verified')->name('home');
Route::inertia('/dashboard', 'Dashboard')->middleware('auth')->name('dashboard');
Route::inertia('/profile', 'Profile/Edit')->middleware(['auth', 'password.confirm'])->name('profile.edit');

require __DIR__ . '/auth.php';
