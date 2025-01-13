<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ModelManagementController;
use App\Http\Controllers\Backend\ResultManagementController;
use App\Http\Controllers\Backend\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('postlogin');

Route::middleware([\App\Http\Middleware\IsSession::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin-management')->as('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/create/admin', [AdminController::class, 'create'])->name('create');
        Route::put('/admin/update/{uuid}', [AdminController::class, 'update'])->name('update');
        Route::put('/admin/update/password/{uuid}', [AdminController::class, 'updatePassword'])->name('update-password');
        Route::delete('/admin/delete/{uuid}', [AdminController::class, 'destroy'])->name('delete');
        Route::delete('/admin/delete/all', [AdminController::class, 'deleteAll'])->name('delete.all');
    });
    

    Route::prefix('user-management')->as('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::post('/create', [UsersController::class, 'create'])->name('create');
        Route::put('/users/update/{uuid}', [UsersController::class, 'update'])->name('update');
        Route::put('/user/update/password/{uuid}', [UsersController::class, 'updatePassword'])->name('update-password');
        Route::delete('/users/delete/{uuid}', [UsersController::class, 'destroy'])->name('delete');
        Route::delete('/users/delete/all', [UsersController::class, 'deleteAll'])->name('delete.all');
    });

    Route::prefix('model-management')->as('model.')->group(function () {
        Route::get('/', [ModelManagementController::class, 'index'])->name('index');
        Route::post('/create', [ModelManagementController::class, 'create'])->name('create');
        Route::delete('/delete/{uuid}', [ModelManagementController::class, 'delete'])->name('delete');
        Route::delete('/model/delete/all', [ModelManagementController::class, 'deleteAll'])->name('delete.all');
    });

    Route::prefix('result-management')->as('result.')->group(function () {
        Route::get('/', [ResultManagementController::class, 'index'])->name('index');
        Route::get('/create', [ResultManagementController::class, 'create'])->name('create');
        Route::post('/store', [ResultManagementController::class, 'store'])->name('store');
    });      
});




