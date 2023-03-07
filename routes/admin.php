<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application.
|
*/
Route::prefix('admin')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users')->middleware('auth', 'admin');

    Route::get('/login', [AuthenticationController::class, 'create'])->name('admin.login');
    Route::post('/login', [AuthenticationController::class, 'store']);
});
