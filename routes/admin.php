<?php

use App\Http\Controllers\Admin\AuthenticationController;
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
    Route::get('/login', [AuthenticationController::class, 'create'])->name('admin.login');
});
