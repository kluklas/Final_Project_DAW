<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    require __DIR__ . '/users.php';
});

Route::middleware('auth:web')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
    Route::get('/avatar', [ProfileController::class, 'getAvatar'])->name('avatar');
});

Route::middleware('auth:web')->prefix('users')->name('users.')->controller(UsersController::class)->group(function () {
    Route::get('/{user}/avatar', 'avatar')->name('avatar');
});

Route::get('/error', function () {
    abort(500);
});

require __DIR__ . '/auth.php';
