<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/delete', [AuthController::class, 'delete']);
    Route::get('/menus', [MenuController::class, 'sendMenus']);
    Route::post('/make-order', [OrderController::class, 'create']);
    Route::get('/menus/{id}', [MenuController::class, 'getSpecificMenu']);
    Route::post('/getUserOrders/', [OrderController::class, 'getOrders']);
});
