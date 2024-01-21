<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\LoginUserController;
use App\Http\Controllers\API\User\CreateUserController;

// Public routes
Route::prefix('users')
    ->group(function () {
        Route::post('register', [CreateUserController::class, '__invoke']);
        Route::post('login', [LoginUserController::class, '__invoke'])->middleware(['auth:sanctum', 'ability:authenticated-user']); //authenticated user only
    });

// Protected routes
Route::middleware(['api', 'auth:sanctum', 'ability:super-admin,admin'])->group(function () {
});
