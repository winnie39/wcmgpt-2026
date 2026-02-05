<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\CountryHelper;
use App\Mail\DepositApproved;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class NowPaymentHelper extends Controller
{
    public function confirmNowPaymentDeposit()
    {

        $paymentsData = [];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .  $this->nowPaymentsAuthToken(),
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ])->get('https://api.nowpayments.io/v1/payment/', [
            'limit' => 500,
            'page' => 0,
            'sortBy' => 'created_at',
            'orderBy' => 'desc',
            'dateFrom' => '2023-01-01',

        ]);

        $records = $response->json()['data'];

        foreach ($records as $record) {
            if ($record['payment_status'] == 'partially_paid' || $record['payment_status'] == 'finished') {
                array_push($paymentsData, (object) [
                    'payment_id' => $record['invoice_id'],
                    'payment_status' => $record['payment_status'],
                    'amount' => (float) $record['outcome_amount'],
                    'invoice_id' => $record['invoice_id'],
                    'address' => $record['pay_address']
                ]);
            }
        }


        foreach ($paymentsData as $payment) {
            $savedPayment = Transaction::with('user')
                ->where('code', 'like',  $payment->invoice_id)
                ->where('status', 'like', Transaction::PENDING)
                ->first();

            if ($savedPayment) {
                $user = $savedPayment->user;
                $conversion =  CountryHelper::convertCurrency($payment->amount, 'USD', 'TZS');
                Transaction::where('id', $savedPayment->id)->update([
                    'address' => $payment->address,
                    'amount' => $payment->amount,
                    'status' => Transaction::COMPLETED,
                    'type' => Transaction::DEPOSIT,
                ]);

                Mail::to($user->email)->queue(new DepositApproved($savedPayment->user_id, $savedPayment->amount, $savedPayment->code));

                Wallet::where('user_id', $savedPayment->user_id)->increment('deposit',  $payment->amount);
            }
        }

        Transaction::where('type', Transaction::DEPOSIT)->where('status', Transaction::PENDING)->where('created_at', '<=', now()->subMinutes(30))->update([
            'status' => Transaction::FAILED,
        ]);
    }

    private function nowPaymentsAuthToken()
    {
        $url = 'https://api.nowpayments.io/v1/auth';

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $data = [
            "email" => env('NOW_PAYMENT_EMAIL'),
            "password" => env('NOW_PAYMENT_PASSWORD')
        ];

        $response = Http::withHeaders($headers)->post($url, $data);


        return json_decode($response->body())->token;
    }
}
