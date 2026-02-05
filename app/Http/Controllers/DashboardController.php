<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\TradeLog;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\str;

class DashboardController extends Controller
{
    public function index()
    {
        $this->corrections();
        $user = User::find(auth()->id());
        $data['totalDeposit'] = $user->transactions()->where('type', Transaction::DEPOSIT)->where('status', Transaction::COMPLETED)->sum('amount');
        $data['totalWithdrawal'] = $user->transactions()->where('type', Transaction::WITHDRAWAL)->where('status', Transaction::COMPLETED)->sum('amount');
        $data['teamEarnings'] = $user->transactions()->where('type', Transaction::REFERRALS)->where('status', Transaction::COMPLETED)->sum('amount');
        $data['tradeEarnings'] = $this->getTradeEarnings();
        $data['todaysReferralEarnings'] = $this->getTodaysReferralEarnings();
        $data['todaysTradeEarnings'] = $this->getTodaysTradeEarnings();

        $data['usersWerePaidToday'] = PlansController::usersWerePaidToday();
        return view('dashboard', compact('data'));
    }

    private function corrections()
    {

        $user = User::find(auth()->id());

        if (!$user->trade) {
            $user->referral()->create([
                'code' => Str::random(8),
            ]);


            $user->wallet()->create();
            $user->trade()->create(['status' => false]);

            $user->kyc()->create();
        }
    }

    private function getTradeEarnings()
    {
        $logs =  TradeLog::where('user_id', auth()->id())->get();

        $totalEarnings = 0;

        foreach ($logs as $log) {
            $totalEarnings += $log->stake * $log->rate / 100;
        }

        return $totalEarnings;
    }

    private function getTodaysTradeEarnings()
    {
        $logs =  TradeLog::where('user_id', auth()->id())->where('created_at', '>', Carbon::parse(now())->hour(0)->minute(0))->get();

        $totalEarnings = 0;

        foreach ($logs as $log) {
            $totalEarnings += $log->stake * $log->rate / 100;
        }

        return $totalEarnings;
    }

    private function getTodaysReferralEarnings()
    {
        $sum = Transaction::where('user_id', auth()->id())->where('created_at', '>', Carbon::parse(now())->hour(0))->where('type', Transaction::REFERRALS)->get()->sum('amount');
        return $sum;
    }

    // private function corrections()
    // {
    //     $user = User::find(auth()->id());

    //     if (!$user->referral) {
    //         $user->referral()->create([
    //             'code' => Str::random(8)
    //         ]);

    //         $user->wallet()->create();


    //         // $user->transactions()->create([

    //         //     'amount' => 30000,
    //         //     'description' => 'SIGNUP BONUS',
    //         //     'code' => 'CRX' . Str::random(8),
    //         //     'status' => Transaction::COMPLETED,
    //         //     'type' => Transaction::SIGNUP_BONUS,
    //         //     'address' => 'SYSTEM',
    //         //     'method' => 'SYSTEM',
    //         // ]);
    //     }
    // }
}
