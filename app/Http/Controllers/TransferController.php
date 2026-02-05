<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\SharesHelper;
use App\Mail\BalanceTransferConfirmationMail;
use App\Mail\BalanceTransferReceived;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransferController extends Controller
{
    public function index()
    {
        [$data['percentage'], $data['flatFee']] = explode('%', env('TRANSFER_FEE', '0.1%0'));
        return view('pages.transfer', compact('data'));
    }

    public function transfer(Request $request)
    {
        $maxAmount = $this->accountBalance();
        $validEmails = User::query()->whereNot('id', auth()->id())->get()->pluck('email');
        $request->validate([
            'amount' => "required|numeric|max:{$maxAmount}|min:5000",
            'email' => ['required', 'email', Rule::in($validEmails)],
        ], [
            'amount.amount' => 'Your balance is insuficient.',
            'amount.in' => 'The email is invalid.',
        ]);


        [$charge['percentage'], $charge['flatFee']] = explode('%', env('TRANSFER_FEE', '0.1%0'));
        $totalCharge = ($charge['percentage'] * $request->amount) + $charge['flatFee'];


        $this->deductFromBalance($request->amount);
        $receiver = User::where('email', $request->email)->first();
        $receiver->wallet()->increment('deposit', $request->amount - $totalCharge);

        $receiver->transactions()->create([
            'amount' => $request->amount,
            'description' => 'P2p transfer from ' . auth()->user()->email,
            'currency' =>    config('app.currency'),
            'method' => 'CRYPTOCURRENCY',
            'status' => Transaction::COMPLETED,
            'type' => Transaction::P2P_TRANSFER_RECEIVE,
            'wallet' => 'deposit',
            'code' => Str::random(8),
        ]);

        (new SharesHelper())->addSharesBalance($request->amount * 0.04);



        User::find(auth()->id())->transactions()->create([
            'amount' => $request->amount,
            'currency' =>    config('app.currency'),
            'description' => 'P2p transfer to ' . $receiver->email,
            'method' => 'CRYPTOCURRENCY',
            'status' => Transaction::COMPLETED,
            'type' => Transaction::P2P_TRANSFER_SEND,
            'wallet' => 'deposit',
            'code' => Str::random(8),
        ]);

        $this->addP2pTranferProfit($request->amount);

        Toastr::success("You have successfully sent {$request->amount} USDT to {$receiver->email}.");

        Mail::to(auth()->user()->email)->queue(new BalanceTransferConfirmationMail(auth()->id(), $receiver->id, $request->amount));
        Mail::to($receiver->email)->queue(new BalanceTransferReceived(auth()->id(), $receiver->id, $request->amount));
        return back();
    }

    private function addP2pTranferProfit($amount)
    {
        [$data['percentage'], $data['flatFee']] = explode('%', env('P2P_TRANSFER_PROFIT', '0.1%0'));

        $profit = (float)((float)$amount * (float) $data['percentage'] + (float) $data['flatFee']);

        User::find(auth()->id())->transactions()->create([
            'amount' => $profit,
            'currency' =>    config('app.currency'),
            'method' => 'CRYPTOCURRENCY',
            'status' => Transaction::COMPLETED,
            'type' => Transaction::P2P_TRANSFER_PROFIT,
            'wallet' => 'deposit',
            'code' => Str::random(8),
        ]);

        User::find(auth()->user()->id)->wallet()->increment('deposit', $profit);

        return true;
    }

    public function confirmEmail(Request $request)
    {
        $emails = User::where('email', '!=', auth()->user()->email)->get()->pluck('email');
        if (in_array($request->email, $emails->toArray())) {
            return true;
        } else {
            return false;
        }
    }

    private function accountBalance()
    {
        $wallet = auth()->user()->wallet;
        return $wallet->deposit + $wallet->profits + $wallet->referral_commission;
    }

    private function deductFromBalance($amount)
    {
        $user = User::find(auth()->id());

        $deductionWallets = ['profits', 'deposit', 'referral_commission', 'stop_bot'];

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
}
