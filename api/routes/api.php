<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

// Users
Route::apiResource('users', UserController::class);