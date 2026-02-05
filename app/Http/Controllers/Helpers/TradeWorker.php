<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Mail\OrderPaidMail;
use App\Models\Trade;
use App\Models\TradeLog;
use App\Models\TradeSetting;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;

class TradeWorker extends Controller
{
    public static function payUsers()
    {

        $index = TradeSettingHelper::getSetting(TradeSetting::INDEX);
        $profit = TradeSettingHelper::getSetting(TradeSetting::PROFIT);
        $constant = TradeSettingHelper::getSetting(TradeSetting::CONSTANT);
        $totalStake = TradeSettingHelper::getSetting(TradeSetting::TOTAL_STAKE);
        $tradeType = TradeSettingHelper::getSetting(TradeSetting::TRADE_TYPE);
        $openingPrice = TradeSettingHelper::getSetting(TradeSetting::OPENING_PRICE);
        $closingPrice = TradeSettingHelper::getSetting(TradeSetting::CLOSING_PRICE);
        $openingTime = TradeSettingHelper::getSetting(TradeSetting::OPENING_TIME);
        $closingTime = TradeSettingHelper::getSetting(TradeSetting::CLOSING_TIME);

        if (strtoupper($tradeType) == "BUY") {
            TradeSettingHelper::update(TradeSetting::PROFIT, ($closingPrice - $openingPrice) * $totalStake / ($openingPrice * $constant));
        } else {
            TradeSettingHelper::update(TradeSetting::PROFIT, ($openingPrice - $closingPrice) * $totalStake / ($openingPrice * $constant));
        }

        $profit = TradeSettingHelper::getSetting(TradeSetting::PROFIT);

        // error_log($profit);
        // return;
        // if ($index > $profit) {
        $rate = $profit *   $constant / $totalStake;
        $trades = Trade::has('user')->get();
        foreach ($trades as $trade) {
            if ($trade->stake > 0) {

                // $hasBeenPaid =  TradeLog::where('user_id', $trade['user_id'])->where('created_at', '>', Carbon::yesterday()->hour(16))->first();

                // if (!$hasBeenPaid) {


                TradeLog::create([
                    'rate' => $rate * 100,
                    'symbol' => strtoupper(TradeSettingHelper::getSetting(TradeSetting::SYMBOL)),
                    'type' => strtoupper(TradeSettingHelper::getSetting(TradeSetting::TRADE_TYPE)),
                    'order_id' => fake()->randomNumber(6) . fake()->randomNumber(6),
                    'bot_opening_time' => Carbon::parse(now())->second(00),
                    'bot_closing_time' => Carbon::parse(now())->second(00),
                    'session_open_time' => $openingTime,
                    'session_close_time' => $closingTime,
                    'session_closing_price' => $closingPrice,
                    'session_opening_price' => $openingPrice,
                    'user_id' => $trade->user_id,
                    'stake' => $trade->stake,
                ]);

                $trade->increment('paid', $trade->stake * $rate);

                error_log('Paying ' . $trade->user->email);

                // Mail::to($trade->user->email)->queue(new OrderPaidMail($trade['user_id']));


                Wallet::where('user_id', $trade->user_id)->increment('profits', $trade->stake * $rate);
            }
            // }
        }


        // self::sendMails();
    }

    public static function sendMails()
    {
        $users = User::get();

        foreach ($users as $user) {
            try {
                Mail::to($user['email'])->queue(new OrderPaidMail($user['id']));
            } catch (Exception $e) {
                dump($e);
            }
        }
    }

    static function handleCompletedTrades()
    {
        $trades = Trade::where('status', true)->get();

        foreach ($trades as $trade) {

            if ($trade['paid'] >= $trade['target']) {
                $trade->update([
                    'stake' => 0,
                    'status' => false,
                    'target' => 0,
                ]);
            }
        }
    }
}
