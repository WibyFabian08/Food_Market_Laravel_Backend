<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\API\MidtransController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')
    ->middleware(['auth:sanctum'])
    ->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('user', UserController::class);
        Route::resource('food', FoodController::class);
    });

// relate midtrans status
Route::get('midtrans/success', [MidtransController::class, 'success'])->name('suucess');
Route::get('midtrans/unfinish', [MidtransController::class, 'unfinish'])->name('suucess');
Route::get('midtrans/failed', [MidtransController::class, 'failed'])->name('suucess');
