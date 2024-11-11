<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'index']);
});
