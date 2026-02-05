<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Referral;
use App\Models\ReferralLevel;
use App\Models\Trade;
use App\Models\TradeLog;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    public function index()
    {

        $method = PaymentMethod::first();

        $data['deposit']['method'] = $method;
        $data['deposit']['amounts'] = [1200, 5000, 10000, 20000, 50000, 1000000];
        $data['withdraw']['method'] = $method;
        [$data['withdraw']['percentage'], $data['withdraw']['flatFee']] = explode('%', $method['rate']);

        $data['refLevels'] = ReferralLevel::get();
        $data['settings']['whatsappLink'] = 'https://whatsapp.com/channel/0029VaSxhDBId7nFihXTM23Z';
        $data['pusher']['broadcaster'] = 'pusher';
        $data['pusher']['key'] = config('broadcasting.connections.pusher.key');
        $data['pusher']['cluster'] = config('broadcasting.connections.pusher.options.cluster');
        $data['pusher']['wsHost'] = env('VITE_PUSHER_HOST') ? env('VITE_PUSHER_HOST') : 'ws-' . env('VITE_PUSHER_APP_CLUSTER') . '.pusher.com';
        $data['pusher']['wsPort'] = config('broadcasting.connections.pusher.options.port') ?? 80;
        $data['pusher']['wssPort'] = config('broadcasting.connections.pusher.options.port') ?? 443;
        $data['pusher']['forceTLS'] = config('broadcasting.connections.pusher.options.scheme');
        $data['pusher']['enabledTransports'] = ["ws", "wss"];
        return $data;
    }

    public function appUserData()
    {
        $data['app'] = $this->index();
        $data['user'] = $this->getUserData();

        return  $data;
    }

    public function downloadApk()
    {
        $filePath = public_path('/app/Mobtenweb3-v1.3.apk');

        return response()->file($filePath, [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="android.apk"',
        ]);
    }


    public static function getUserData()
    {

        $user =  User::find(auth()->id());
        $data['user'] = $user;
        $data['transactions'] = $data['user']['transactions'];
        $data['team'] = Referral::whereHas('user')->latest()->where('referrer_id', auth()->id())->get();

        $data['referral'] = $user->referral;
        $data['settings']['currency'] = config('app.currency');

        $data['plans']['orderHistory'] = (new PlansController())->getOrderHistory();
        $data['plans']['hasPlan'] = $user->trade->stake > 0;
        $data['wallets']['totalWithdrawals'] = $user->transactions()->where('type', Transaction::WITHDRAWAL)->sum('amount');
        $data['wallets']['totalDeposit'] = $user->transactions()->where('type', Transaction::DEPOSIT)->sum('amount');
        $data['wallets']['approvedWithdrawals'] = $user->transactions()->where('type', Transaction::WITHDRAWAL)->where('status', Transaction::COMPLETED)->sum('amount');
        $data['wallets']['pendingWithdrawals'] = $user->transactions()->where('type', Transaction::WITHDRAWAL)->where('status', Transaction::PENDING)->sum('amount');
        $data['wallets']['totalRecharge'] = $user->transactions()->where('type', Transaction::DEPOSIT)->where('status', Transaction::COMPLETED)->sum('amount');
        $data['wallets']['totalTrades'] = TradeLog::where('user_id', auth()->id())->count();





        $data['wallets']['depositBalance'] = config('app.currency') . number_format($user->wallet->deposit);
        $data['wallets']['netProfit'] = config('app.currency') . number_format($user->wallet->profits);
        $data['wallets']['referralBonus'] = config('app.currency') . number_format($user->wallet->referral_commission);
        $data['wallets']['totalBalance'] = config('app.currency') . number_format($user->wallet->profits + $user->wallet->referral_commission + $user->wallet->deposit);
        $data['wallets']['availableBalance'] = config('app.currency') . number_format($user->wallet->referral_commission + $user->wallet->deposit);

        return $data;
    }

    public function login(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|string',
                'password' => "required|string",
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['email' => ['The provided credentials are incorrect.']], 422);
        }

        return $user->createToken('AUTH_TOKEN')->plainTextToken;
    }
}
