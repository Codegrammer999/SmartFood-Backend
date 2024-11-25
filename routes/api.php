<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/submit-payment', [AuthController::class, 'submitPaymentReceipt']);
Route::post('/register/code/verify', [CodeController::class, 'verifyRegistrationCode']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/delete', [AuthController::class, 'delete']);
    Route::post('/menus', [MenuController::class, 'sendMenus']);
    Route::post('/make-order', [OrderController::class, 'create']);
    Route::get('/menus/{id}', [MenuController::class, 'getSpecificMenu']);
    Route::post('/getUserOrders', [OrderController::class, 'getOrders']);
    Route::post('/code/create', [CodeController::class, 'create']);
    Route::post('/user/codes', [CodeController::class, 'getUserCodes']);

});
