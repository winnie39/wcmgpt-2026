<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\TradeWorker;
use App\Mail\OrderPaidMail;
use App\Models\Referral;
use App\Models\Trade;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;

class Corrections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:corrections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Mail::to('stockbullca@gmail.com')->queue(new OrderPaidMail($parameter1));
        // error_log();


        // $users = User::get();

        // User::where('email', 'like', 'admin2@admin.com')->delete();
        // $wallets = Wallet::get();

        // $referrals = Referral::get();

        // foreach ($wallets as $wallet) {

        TradeWorker::payUsers();

        // if (!$wallet->user) {
        //     $wallet->delete();
        //     // $referral->delete();
        // }

        // if (!$user->referral) {
        //     $user->referral()->create([
        //         'code' => Str::random(8)
        //     ]);

        //     error_log('Creating for ' . $user->email);
        // }
        // if (!$wallet->user) {
        //     $wallet->delete();

        //     error_log('Error in wallet ' . $wallet->id);
        // }
        // }
    }
}
