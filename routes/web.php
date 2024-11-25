<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

Route::middleware(['admin'])->group(function () {
    Route::get('/', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/admin', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
});

Route::prefix('admin')->group(function (){

    Route::middleware(['guest'])->group(function () {

        Route::get('/register', [AdminController::class, 'showRegister'])->name('admin.register');
        Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
        Route::post('/register', [AdminController::class, 'register']);
        Route::post('/login', [AdminController::class, 'login']);

   });

    Route::middleware(['admin'])->group(function () {

        Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/menus', [AdminController::class, 'showMenus'])->name('admin.menus');
        Route::get('/codes/pending', [AdminController::class, 'showCodes'])->name('admin.pending-codes');
        Route::post('/code/{id}/activate', [AdminController::class, 'activateCode'])->name('admin.activate-code');
        Route::get('/menu/add', [MenuController::class, 'show'])->name('admin.show-menu');
        Route::get('/menu/{id}', [MenuController::class, 'showMenu'])->name('admin.menu');
        Route::get('/order/user/{id}', [AdminController::class, 'showOrderOwner'])->name('admin.viewOrderOwner');
        Route::get('/users/pending', [AdminController::class, 'showPendingUsers'])->name('admin.pending-users');
        Route::get('/orders', [AdminController::class, 'showPendingOrders'])->name('admin.orders');
        Route::post('/menu/delete', [MenuController::class, 'delete']);
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::post('/menu/create', [MenuController::class, 'create'])->name('admin.add-menu');
        Route::post('/order/{id}/confirm', [AdminController::class, 'confirmOrder'])->name('admin.confirmOrder');
	    Route::post('/users/{id}/confirm', [AdminController::class, 'confirmUserRegistration'])->name('users.confirm');
	    Route::post('/users/{id}/reject', [AdminController::class, 'rejectUserRegistration'])->name('admin.rejectUser');

    });

});
