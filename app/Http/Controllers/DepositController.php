<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\AppHelper;
use App\Http\Controllers\Helpers\CountryHelper;
use App\Http\Controllers\Helpers\ReferralHelper;
use App\Mail\DepositMail;
use App\Mail\PendingDeposit;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DepositController extends Controller
{
    function index()
    {
        $data['methods'] = PaymentMethod::get();

        return view('pages.deposit', compact('data'));
    }

    public function deposit(Request $request)
    {

        $allowedPaymentMethods = PaymentMethod::get()->pluck('id');

        $request->validate([
            'amount' => 'required|numeric|min:20000',
            'method' => ['required', Rule::in($allowedPaymentMethods)],
            'image' => ' required|mimes:png,jpg,jpeg',
            'address' => 'required',
        ], [
            'address.required' => 'This field is required',
            'method.required' => 'The payment method field is required',
            'method.in' => 'Invalid payment method',
        ]);

        $pendingDeposits = Transaction::query()->where('user_id', auth()->id())->where('type', Transaction::DEPOSIT)->where('status', Transaction::PENDING)->first();

        if ($pendingDeposits) {
            Toastr::warning('You have a pending deposit, please try again later.');
            return back();
        }


        $image = $request->file('image');


        $method = PaymentMethod::find($request->input('method'));


        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $data =  $image->move(public_path('storage/images'), $imageName);

        $transaction =   User::find(auth()->id())->transactions()->create([
            'amount' => $request->amount,
            'currency' => $method['currency'],
            'method' => $method['name'],
            'description' => 'Deposit',
            'amount_before_deduction' => $request->amount,
            'status' => Transaction::PENDING,
            'type' => Transaction::DEPOSIT,
            'wallet' => 'deposit',
            'address' => $request->input('address'),
            'code' => strtoupper(Str::random(8)),
            'image' => '/images/' . $imageName,
        ]);

        Toastr::success('Deposit request was sent successfully.');

        return back();
    }

    public function appDeposit(Request $request)
    {

        $allowedPaymentMethods = PaymentMethod::get()->pluck('id');

        $request->validate([
            'amount' => 'required|numeric|min:20000',
            // 'method' => ['required', Rule::in($allowedPaymentMethods)],
            'image' => ' required|mimes:png,jpg,jpeg',
            'address' => 'required',
        ], [
            'address.required' => 'This field is required',
            'method.required' => 'The payment method field is required',
            'method.in' => 'Invalid payment method',
        ]);

        $pendingDeposits = Transaction::query()->where('user_id', auth()->id())->where('type', Transaction::DEPOSIT)->where('status', Transaction::PENDING)->first();

        if ($pendingDeposits) {
            return AppHelper::error('You have a pending deposit, please try again later.');
        }


        $image = $request->file('image');


        $method = PaymentMethod::first();


        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $data =  $image->move(public_path('storage/images'), $imageName);
        $transaction =   User::find(auth()->id())->transactions()->create([
            'amount' => $request->amount,
            'currency' => $method['currency'],
            'method' => $method['name'],
            'description' => 'Deposit',
            'amount_before_deduction' => $request->amount,
            'status' => Transaction::PENDING,
            'type' => Transaction::DEPOSIT,
            'wallet' => 'deposit',
            'address' => $request->input('address'),
            'code' => strtoupper(Str::random(8)),
            'image' => '/images/' . $imageName,
        ]);

        return AppHelper::success('Deposit request was sent successfully.');
    }

    private function getNowPaymentInvoiceLink($amount)
    {
        $orderId = Str::random(8);
        $code = Str::random(10);
        $response = Http::withHeaders([
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.nowpayments.io/v1/invoice', [
            'price_amount' => $amount + 2.6,
            'price_currency' => 'usd',
            'order_id' =>  $orderId,
            'order_description' => 'WCMGPT',
            'success_url' => url('/api/deposit-success/' . $code),
            'cancel_url' =>  url('/api/deposit-failure/' . $code),
        ]);

        $responseData = json_decode($response->body());

        $transaction =   User::find(auth()->id())->transactions()->create([
            'amount' => $amount,
            'currency' => 'usd',
            'method' => 'CRYPTOCURRENCY',
            'amount_before_deduction' => $amount,
            'status' => Transaction::PENDING,
            'type' => Transaction::DEPOSIT,
            'wallet' => 'deposit',
            'code' => $responseData->id,
        ]);




        Mail::to(auth()->user()->email)->queue(new PendingDeposit(auth()->id(), $transaction->amount, $transaction->code));

        return $responseData->invoice_url;
    }

    public static function approveManualDeposit($id)
    {
        $transaction  = Transaction::find($id);

        $conversion = CountryHelper::convertCurrency($transaction->amount, $transaction->currency, config('app.currency'));
        $amount = $transaction->amount * $conversion->constant;

        $transaction->update([
            'status' => Transaction::COMPLETED,
            'currency' => config('app.currency'),
            'amount' => $amount,
            'amount_before_deduction' => $amount,
        ]);


        if (File::exists(public_path('/storage' . $transaction->image))) {
            File::delete(public_path('/storage' . $transaction->image));
        }


        User::find($transaction->user_id)->wallet()->increment($transaction->wallet, $amount);


        return back();
    }

    public static function rejectManualPayments($id)
    {

        $transaction  = Transaction::find($id);

        $transaction->update([
            'status' => Transaction::FAILED,
        ]);

        if (File::exists(public_path($transaction->image))) {
            File::delete(public_path($transaction->image));
        }

        return back();
    }


    public static function payLevelOne($userId, $amount)
    {
        $rate = 0.1;
        $user = User::find($userId);
        $profit  = $amount * $rate;
        if ($user->referral->referrer_id) {

            $referer = User::find($user->referral->referrer_id);


            if ($referer) {
                $referer->wallet()->increment('referral_commission', $rate * $amount);
            } else {
                return;
            }

            Transaction::create([
                'user_id' => $referer->user_id,
                'amount' => $profit,
                'status' => Transaction::COMPLETED,
                'type' => Transaction::REFERRALS,
                'transaction_code' => Str::random(8),
                'wallet' => 'referral_commission',
                'address' => 'PELYCAN',
                'description' => 'Deposit',
            ]);
        }

        return;
    }
}
