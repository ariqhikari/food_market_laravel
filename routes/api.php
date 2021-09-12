<?php

use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\API\Dashboard\FoodController as DashboardFoodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'fetch']);
        Route::put('/', [UserController::class, 'updateProfile']);
        Route::put('photo', [UserController::class, 'updatePhoto']);
    });

    Route::post('logout', [UserController::class, 'logout']);

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'all']);
        Route::put('{id}', [TransactionController::class, 'update']);
    });

    Route::post('checkout', [TransactionController::class, 'checkout']);
});

Route::prefix('dashboard')->group(function () {
    Route::resource('user', DashboardUserController::class)->except(['create', 'edit']);
    Route::resource('food', DashboardFoodController::class)->except(['create', 'edit']);
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('food', [FoodController::class, 'all']);

Route::post('midtrans/callback', [MidtransController::class, 'callback']);
