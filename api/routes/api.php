<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Auth
    Route::get('/check', [AuthController::class, 'check']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Users
    Route::apiResource('users', UserController::class);
});