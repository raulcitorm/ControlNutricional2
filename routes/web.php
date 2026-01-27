<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatsController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/stats', [StatsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('stats');

require __DIR__.'/auth.php';
