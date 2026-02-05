<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\Helpers\CountryHelper;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WithdrawController;
use App\Mail\TestMail;
use App\Models\Trade;
use App\Models\TradeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/',  [DashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/change-password', [ProfileController::class, 'changePassword']);

    Route::get('/transactions', [TransactionsController::class, 'index']);

    Route::get('/deposit', [DepositController::class, 'index']);
    Route::post('/deposit', [DepositController::class, 'deposit']);
    Route::get('/withdraw', [WithdrawController::class, 'index']);
    Route::post('/withdraw', [WithdrawController::class, 'withdraw']);

    Route::post('/change-bot-status', [PlansController::class, 'changeBotStatus']);
    Route::get('/plans', [PlansController::class, 'index']);
    Route::post('/stake', [PlansController::class, 'stake']);
    Route::post('/pay-users', [PlansController::class, 'payUsers']);
    Route::get('/order-history', [PlansController::class, 'orderHistory']);
    Route::get('/verification', [UserController::class, 'kyc']);
    Route::get('/team', [TeamController::class, 'index']);
    Route::get('/transfer', [TransferController::class, 'index']);
    Route::post('/transfer', [TransferController::class, 'transfer']);
    Route::post('/transfer/receiver-mail', [TransferController::class, 'confirmEmail']);

    Route::get('/countries', [CountryHelper::class, 'getAllCountries']);
    Route::post('/verify', [UserController::class, 'verify']);
});



Route::get('/test-mail', function () {
    return  Trade::query()->whereRelation('user', function ($query) {
        return $query->whereNotIn('email', config('app.admins'));
    })->where('status', true)->sum('stake');
});

require __DIR__ . '/auth.php';
