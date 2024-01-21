<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\LoginUserController;
use App\Http\Controllers\API\User\CreateUserController;
use App\Http\Controllers\API\Company\CreateCompanyController;
use App\Http\Controllers\API\StockMarket\GetStockMarketController;

// Public routes
Route::prefix('users')
    ->group(function () {
        Route::post('register', [CreateUserController::class, '__invoke']);
        Route::post('login', [LoginUserController::class, '__invoke']);
    });

Route::prefix('stockmarkets')
    ->group(function () {
        Route::get('stock', [GetStockMarketController::class, '__invoke']);
    });

// Protected routes , 'ability:super-admin,admin,standard'
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::post('companies/register', [CreateCompanyController::class, '__invoke']);
});
