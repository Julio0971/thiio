<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// Login
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    // Auth
    Route::get('/check', [AuthController::class, 'check']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Users
    Route::get('/users/{search?}', [UserController::class, 'index']);
    Route::apiResource('users', UserController::class)->except('index');
});