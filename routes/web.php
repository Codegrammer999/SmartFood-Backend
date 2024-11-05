<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

Route::middleware(['guest'])->group(function () {

    Route::get('/register', function () {
        return view('admin.register');
    });

    Route::get('/login', function () {
        return view('admin.login');
    });

    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
});

Route::middleware(['role'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/orders', [AdminController::class, 'show']);

    Route::post('/delete-menu', [MenuController::class, 'delete']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::post('/create-menu', [MenuController::class, 'create']);
    Route::post('/confirm-order', [AdminController::class, 'confirmOrder']);

});
