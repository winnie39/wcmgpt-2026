<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AppController::class, 'getUserData']);
    });

    // Route::post('/submit-promo-code', [PromotionCodesController::class, 'appSubmitCode']);
    Route::post('/deposit', [DepositController::class, 'appDeposit']);
    Route::post('/withdraw', [WithdrawController::class, 'withdrawApp']);
    Route::post('/plan/subscribe/{id}', [PlansController::class, 'subscribeApp']);
    Route::post('/update-profile', [ProfileController::class, 'appUpdateProfile']);

    Route::post('/trade', [PlansController::class, 'tradeApp']);
    Route::get('/get-user-app-data', [AppController::class, 'appUserData']);
});


Route::get('/get-data', [AppController::class, 'index']);
Route::post('/login', [AppController::class, 'login']);
