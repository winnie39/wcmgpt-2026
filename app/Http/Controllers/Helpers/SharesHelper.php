<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Share;
use Illuminate\Support\Facades\Mail;

class SharesHelper extends Controller
{
    private $app;

    public function __construct()
    {
        $this->app['name'] = strtoupper(config('app.name'));
    }


    public function informShares()
    {
        $shares = Share::get();
        $senderMessage = "";

        foreach ($shares as $key => $share) {

            if ($share['amount'] > 0) {
                Mail::raw("Your earnings for today are {$share['amount']}{$share['currency']}.", function ($message) use ($share) {
                    $message->to($share->email)->subject("{$this->app['name']}: {$share->amount}USD");
                });
            }

            $senderMessage .= "{$share->name} todays eanings are {$share->amount}{$share['currency']} .\n";
        }
        $this->informSender($senderMessage);
        $this->clearBalances();
    }

    private function informSender($message)
    {
        $shares = Share::where('sender', true)->get();
        foreach ($shares as $share) {
            if ($share['amount'] > 0) {
                Mail::raw($message, function ($message) use ($share) {
                    $message->to($share->email)->subject("{$this->app['name']}: PLEASE RELEASE SHARE PAYMENTS.");
                });
            }
        }
    }

    private function clearBalances()
    {
        Share::where('name', '!=', null)->update([
            'amount' => 0
        ]);
    }

    public static function addSharesBalance($amount)
    {
        $shares =  Share::get();
        foreach ($shares as $key => $share) {
            Share::whereId($share->id)->increment('amount', (float) $amount * (float) $share['rate']);
        }

        return true;
    }
}
