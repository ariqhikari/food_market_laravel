<?php

use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page
Route::get('/', function () {
    return redirect()->route('admin-dashboard');
});

// Dashboard Page
Route::prefix('dashboard')->middleware(['auth:sanctum', 'verified', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');
    Route::resource('users', UserController::class);
    Route::resource('food', FoodController::class);

    Route::get('transactions/{transaction}/status/{status}', [TransactionController::class, 'changeStatus'])->name('transactions.changeStatus');
    Route::resource('transactions', TransactionController::class);
});

// Midtrans related
Route::prefix('midtrans')->group(function () {
    Route::get('success', [MidtransController::class, 'success']);
    Route::get('unfinish', [MidtransController::class, 'unfinish']);
    Route::get('error', [MidtransController::class, 'error']);
});
