<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::get('/', 'index');

    Route::group(['prefix' => 'user'], function() {
        Route::post('/create', 'store');
        Route::put('/edit/{id}', 'update');
        Route::put('/delete/{id}', 'update');
        Route::get('/{id}', 'show');
        Route::delete('/delete/{id}', 'destroy');
    });
});