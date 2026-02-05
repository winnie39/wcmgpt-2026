<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\AdminHelper;
use App\Http\Controllers\Helpers\AppHelper;
use App\Http\Controllers\Helpers\ReferralHelper;
use App\Http\Controllers\Helpers\SharesHelper;
use App\Http\Controllers\Helpers\TradeSettingHelper;
use App\Http\Controllers\Helpers\TradeWorker;
use App\Models\Trade;
use App\Models\TradeLog;
use App\Models\TradeSetting;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PlansController extends Controller
{
    public function index()
    {
        return view('pages.plans');
    }

    private $startTime;

    public function orderHistory()
    {
        $tradeLogs = $this->getOrderHistory();
        return view('pages.order-history', compact('tradeLogs'));
    }

    public  function getOrderHistory()
    {
        $user = User::find(auth()->id());

        if (!Trade::where('user_id', auth()->id())->first()) {
            Trade::create([
                'user_id' => auth()->id(),
            ]);
        }

        $trade = Trade::where('user_id', auth()->id())->first();
        $undefined = 'waiting...';
        $firstLog = TradeLog::where('user_id', auth()->id())->orderBy('created_at', 'asc')->first();
        $this->startTime = Carbon::parse($firstLog ? $firstLog->bot_closing_time : now())->subDay();
        $tradeLogs = TradeLog::where('user_id', auth()->id())->orderBy('created_at', 'asc')->get()->map(function ($value) use ($trade, $undefined) {
            $data =  (object) [
                'actual_profits_and_loss' => $trade->stake * $value->rate / 100  ?? $undefined,
                'status' => $trade->status ?? $undefined,
                'order_profit_and_loss' => 0 ?? $undefined,
                'deferred_fee' => 0 ?? $undefined,
                'handling_fee' => 0 ?? $undefined,
                'order_id' => $value->order_id,
                'rate' => $value->rate . '%',
                'margin' => $trade->stake,
                'bot_start_time' => $this->startTime . 'UTC' ?? $undefined,
                'bot_close_time' => $value->bot_closing_time . 'UTC' ?? $undefined,
                'order_type' =>  $value->type  ?? $undefined,
                'symbol' => $value->symbol ?? $undefined,
                'occupy_margin' => $value->stake ?? $undefined,
                'session_open_price' => $value->session_opening_price ?? $undefined,
                'session_close_price' => $value->session_closing_price ?? $undefined,
                'session_open_time' => $value->session_open_time,
                'session_close_time' => $value->session_close_time,
            ];

            $this->startTime = $value->bot_closing_time;

            return $data;
        });

        $tradeLogs = $tradeLogs->reverse();

        if ($trade->stake > 0) {
            $emptylogs = (object) [
                'actual_profits_and_loss' =>  $undefined,
                'status' => $trade->status ?? $undefined,
                'order_profit_and_loss' =>  $undefined,
                'deferred_fee' => 0 ?? $undefined,
                'handling_fee' => 0 ?? $undefined,
                'rate' => $undefined,
                'order_id' => $undefined,
                'margin' => $trade->stake,
                'bot_start_time' =>  $undefined,
                'bot_close_time' =>  $undefined,
                'order_type' =>   $undefined,
                'symbol' =>  $undefined,
                'occupy_margin' =>  $undefined,
                'session_open_price' =>   $undefined,
                'session_close_price' =>  $undefined,
                'session_open_time' =>  $undefined,
                'session_close_time' => $undefined,
            ];
            $tradeLogs->prepend($emptylogs);
        }

        return $tradeLogs;
    }

    public function stake(Request $request)
    {
        $maximum  = $this->accountBalance();

        if (!$request->amount) {
            Toastr::warning('The amount field is required');
            return back();
        }

        if (!is_numeric($request->amount)) {
            Toastr::warning('The amount field must be numeric');
            return back();
        }

        if ($request->amount < 20000) {
            Toastr::warning('Minimum stake amount is 20,000TZS');
            return back();
        }

        if ($request->amount > $maximum) {
            Toastr::warning('Your balance is below ' . number_format($request->amount) . 'TZS');
            return back();
        }


        $this->deductFromBalance($request->amount);
        $user = User::find(auth()->id());
        $userTrade = $user->trade;

        $stopBotBalance = $user->wallet->stop_bot;

        $user->wallet()->decrement('stop_bot', $stopBotBalance);


        $user->trade()->update([
            'stake' => $userTrade->stake + $request->amount + $stopBotBalance,
            'target' => $userTrade->target + ($request->amount * 2) + ($stopBotBalance * 2),
            'status' => true,
        ]);


        $referralClass = (new ReferralHelper())->newRef(auth()->id(), $request->amount);

        SharesHelper::addSharesBalance($request->amount);

        // (new SharesHelper())->addSharesBalance($request->amount);


        return redirect('/order-history');
    }

    public function tradeApp(Request $request)
    {
        $maximum  = $this->accountBalance();

        if (!$request->amount) {
            return AppHelper::error('The amount field is required');
        }

        if (!is_numeric($request->amount)) {
            return  AppHelper::error('The amount field must be numeric');
        }

        if ($request->amount < 20000) {
            return  AppHelper::error('Minimum stake amount is 20,000TZS');
        }

        if ($request->amount > $maximum) {
            return  AppHelper::error('Your balance is below ' . number_format($request->amount) . 'TZS');
        }


        $this->deductFromBalance($request->amount);
        $user = User::find(auth()->id());
        $userTrade = $user->trade;

        $stopBotBalance = $user->wallet->stop_bot;

        $user->wallet()->decrement('stop_bot', $stopBotBalance);


        $user->trade()->update([
            'stake' => $userTrade->stake + $request->amount + $stopBotBalance,
            'target' => $userTrade->target + ($request->amount * 2) + ($stopBotBalance * 2),
            'status' => true,
        ]);


        $referralClass = (new ReferralHelper())->newRef(auth()->id(), $request->amount);

        SharesHelper::addSharesBalance($request->amount);

        // (new SharesHelper())->addSharesBalance($request->amount);


        return redirect('/order-history');
    }

    private function accountBalance()
    {
        $wallet = User::find(auth()->id())->wallet;
        $profitBalance = $wallet->profits;
        $accountBalance = $wallet->deposit;
        return $accountBalance  + $wallet->referral_commission;
    }

    private function deductFromBalance($amount)
    {
        $user = User::find(auth()->id());

        $deductionWallets = ['deposit', 'referral_commission'];

        $remainingAmount = $amount;
        foreach ($deductionWallets as $item) {
            if ($remainingAmount > 0) {
                if ($remainingAmount < $user->wallet[$item]) {
                    $user->wallet()->decrement($item, $remainingAmount);
                    break;
                } else {
                    $user->wallet()->decrement($item, $user->wallet[$item]);
                    $remainingAmount -= $user->wallet[$item];
                    continue;
                }
            }
        }
    }

    public function payUsers()
    {
        if (!in_array(auth()->user()->email, config('app.admins'))) {
            abort(403);
        }

        if (self::usersWerePaidToday()) {
            return back();
        }

        Cache::put('lastTradePayment', now());

        TradeWorker::payUsers();

        return back();
    }

    public function changeBotStatus(Request $request)
    {
        // $user = User::find(auth()->id());
        // $currentStatus = $user->trade->status;

        // $index = TradeSettingHelper::getSetting(TradeSetting::INDEX);

        // if ($user->trade->stake < 1 && $user->wallet->stop_bot < 1) {
        //     Toastr::warning('Please stake first');
        //     return back();
        // }


        // if ($index > $user->trade->stake) {

        //     if ($currentStatus) {
        //         $user->wallet()->increment('stop_bot', $user->trade->stake);
        //         $user->trade()->update([
        //             'stake' => 0,
        //             'target' => 0
        //         ]);

        //         if (!AdminHelper::isAdmin()) {
        //             TradeSettingHelper::decrement(TradeSetting::INDEX, $user->trade->stake);
        //         }
        //     } else {
        //         $user->trade()->increment('stake', $user->wallet->stop_bot);
        //         $user->trade()->increment('target', $user->wallet->stop_bot * 2);
        //         $user->wallet()->update([
        //             'stop_bot' => 0,
        //         ]);

        //         if (!AdminHelper::isAdmin()) {
        //             TradeSettingHelper::increment(TradeSetting::INDEX, $user->wallet->stop_bot);
        //         }
        //     }


        //     $user->trade()->update([
        //         'status' => $currentStatus > 0 ? 0 : 1,
        //     ]);

        //     Toastr::success('Bot settings updated successfully.');
        // } else {
        //     Toastr::warning('Failed, please try again later.');
        // }

        // return back();
    }



    public static function usersWerePaidToday()
    {
        $lastPayment = Cache::get('lastTradePayment');

        if (!$lastPayment) {
            Cache::put('lastTradePayment', now());
            return false;
        }


        $tradeLogTime = Carbon::parse($lastPayment);
        $todaysTime  = Carbon::parse(now());
        if ($todaysTime->day != $tradeLogTime->day) {
            return false;
        } else {
            return true;
        }
    }
}
