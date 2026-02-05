<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\AppHelper;
use App\Http\Controllers\Helpers\CountryHelper;
use App\Http\Controllers\Helpers\TradeSettingHelper;
use App\Models\PaymentMethod;
use App\Models\TradeSetting;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WithdrawController extends Controller
{
    public function index()
    {

        $rates = CountryHelper::getRates();
        // $rates = 1;
        $data['methods'] = PaymentMethod::get()->map(function ($value) use ($rates) {

            [$charge['percentage'], $charge['flatFee']] = explode('%', $value['rate']);

            return [

                'name' => $value['name'],
                'phone' => $value['phone'],
                'description' => $value['description'],
                'rate' => $value['rate'],
                'currency' => $value['currency'],
                'parameter' => $value['parameter'],
                // 'conversion' => 1,
                'conversion' => $rates[$value['currency']],
                'id' => $value['id'],
                'percentage' => $charge['percentage'],
                'flatFee' => $charge['flatFee'],

            ];
        });

        [$data['percentage'], $data['flatFee']] = explode('%', env('WITHDRAW_FEE', '0.1%0'));

        return view('pages.withdraw', compact('data'));
    }

    public function withdraw(Request $request)
    {

        $allowedPaymentMethods = PaymentMethod::get()->pluck('id');
        $allowedWallets = ['profits', 'bonus'];

        $accountBalance = $this->accountBalance($request->wallet);
        $currency = config('app.currency');
        $request->validate([
            'amount' => "required|numeric|min:10000|max:{$accountBalance}",
            'method' => ['required', Rule::in($allowedPaymentMethods)],
            'address' => 'required',
            'wallet' => ['required', Rule::in($allowedWallets)]
        ], [
            'address.required' => 'This field is required',
            'method.required' => 'The payment method field is required',
            'method.in' => 'Invalid payment method',
            'amount' => "Your balance is below {$currency}{$request->amount}",
        ]);

        if ($request->amount > $accountBalance) {
            Toastr::warning('Your balance is insuficient');
            return back();
        }


        $user = User::find(auth()->id());


        if ($user->transactions()->where('type', Transaction::WITHDRAWAL)->where('status', Transaction::PENDING)->first()) {
            Toastr::warning('Failed, you have a pending withdrawal, please wait until it is approved');
            return back();
        }

        $extraWallet = TradeSettingHelper::getSetting(TradeSetting::EXTRA_WALLET);

        if ($extraWallet < $request->amount) {
            Toastr::warning('Trade ongoing, please try again later.');
            return back();
        }

        $rates = CountryHelper::getRates();
        $method = PaymentMethod::find($request->method);
        [$charge['percentage'], $charge['flatFee']] = explode('%', $method['rate']);

        $amount = $request->amount * $rates[$method['currency']];

        $totalCharge = ($charge['percentage'] * $amount) + $charge['flatFee'];

        $user = User::find(auth()->id());
        $this->deductFromBalance($request->amount, $request->wallet);
        $user->transactions()->create([
            'amount' => $amount - $totalCharge,
            'currency' =>    $method['currency'],
            'method' => $method['name'],
            'amount_before_deduction' => $amount,
            'status' => Transaction::PENDING,
            'address' => str_replace(' ', '', $request->address),
            'type' => Transaction::WITHDRAWAL,
            'wallet' => 'deposit',
            'code' => strtoupper(Str::random(8)),
        ]);


        $currency = config('app.currency');
        Toastr::success("Your withdrawal request of {$request->amount} {config('app.currency)} was sent successfully.");

        return back();
    }

    public function withdrawApp(Request $request)
    {
        $allowedPaymentMethods = PaymentMethod::get()->pluck('id');
        $allowedWallets = ['profits', 'bonus'];

        $accountBalance = $this->accountBalance($request->wallet);
        $currency = config('app.currency');
        $request->validate([
            'amount' => "required|numeric|min:10000|max:{$accountBalance}",
            'method' => ['required', Rule::in($allowedPaymentMethods)],
            'address' => 'required',
            'wallet' => ['required', Rule::in($allowedWallets)]
        ], [
            'address.required' => 'This field is required',
            'method.required' => 'The payment method field is required',
            'method.in' => 'Invalid payment method',
            'amount' => "Your balance is below {$currency}{$request->amount}",
        ]);

        if ($request->amount > $accountBalance) {
            AppHelper::error('Your balance is insuficient');
            return back();
        }


        $user = User::find(auth()->id());


        if ($user->transactions()->where('type', Transaction::WITHDRAWAL)->where('status', Transaction::PENDING)->first()) {
            AppHelper::error('Failed, you have a pending withdrawal, please wait until it is approved');
            return back();
        }

        $extraWallet = TradeSettingHelper::getSetting(TradeSetting::EXTRA_WALLET);

        if ($extraWallet < $request->amount) {
            AppHelper::error('Trade ongoing, please try again later.');
            return back();
        }

        $rates = CountryHelper::getRates();
        $method = PaymentMethod::find($request->method);
        [$charge['percentage'], $charge['flatFee']] = explode('%', $method['rate']);

        $amount = $request->amount * $rates[$method['currency']];

        $totalCharge = ($charge['percentage'] * $amount) + $charge['flatFee'];

        $user = User::find(auth()->id());
        $this->deductFromBalance($request->amount, $request->wallet);
        $user->transactions()->create([
            'amount' => $amount - $totalCharge,
            'currency' =>    $method['currency'],
            'method' => $method['name'],
            'amount_before_deduction' => $amount,
            'status' => Transaction::PENDING,
            'address' => str_replace(' ', '', $request->address),
            'type' => Transaction::WITHDRAWAL,
            'wallet' => 'deposit',
            'code' => strtoupper(Str::random(8)),
        ]);


        $currency = config('app.currency');
        AppHelper::success("Your withdrawal request of {$request->amount} {config('app.currency)} was sent successfully.");

        return back();
    }

    private function accountBalance($selectedWallet)
    {

        $wallet = User::find(auth()->id())->wallet;
        if ($selectedWallet == 'bonus') {
            $balance =  $wallet->referral_commission;
        } else if ($selectedWallet == 'profits') {
            $balance = $wallet->profits;
        } else {
            $balance = 0;
        }


        return $balance;
    }

    public static function approveWithdraw($id)
    {
        Transaction::where('id', $id)->update([
            'status' => Transaction::COMPLETED,
        ]);
    }

    public static function declineWithdrawal($id)
    {
        Transaction::where('id', $id)->update([
            'status' => Transaction::FAILED,
        ]);
    }

    private function deductFromBalance($amount, $wallet)
    {
        $user = User::find(auth()->id());

        if ($wallet == 'bonus') {
            $user->wallet()->decrement('referral_commission', $amount);
        } else {
            $user->wallet()->decrement('profits', $amount);
            TradeSettingHelper::decrement(TradeSetting::EXTRA_WALLET, $amount);
        }

        // $deductionWallets = ['profits',  'referral_commission', 'stop_bot'];

        // $remainingAmount = $amount;
        // foreach ($deductionWallets as $item) {
        //     if ($remainingAmount > 0) {
        //         if ($remainingAmount < $user->wallet[$item]) {
        //             $user->wallet()->decrement($item, $remainingAmount);
        //             break;
        //         } else {
        //             $user->wallet()->decrement($item, $user->wallet[$item]);
        //             $remainingAmount -= $user->wallet[$item];
        //             continue;
        //         }
        //     }
        // }
    }
}
