<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web','role:Admin'])->prefix('users')->name('users.')->controller(UsersController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/listado', 'listado')->name('listado');
    Route::get('/modal/{user?}', 'modal')->name('modal');
    Route::post('/store', 'store')->name('store');
    Route::post('/update/{user}', 'update')->name('update');
    Route::post('/updateStatus/{user}', 'updateStatus')->name('updateStatus');
});
