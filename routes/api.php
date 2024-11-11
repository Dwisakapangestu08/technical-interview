<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiAuthController;

Route::post('/login', [ApiAuthController::class, 'index']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/forgot-password', [ApiAuthController::class, 'forgot_password']);
