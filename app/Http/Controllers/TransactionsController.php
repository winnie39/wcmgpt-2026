<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $types = ['DEPOSIT', 'WITHDRAWAL', 'INVESTMENT', 'SIGNUP_BONUS', 'REFERRALS'];

        if (in_array($request->input('type'), $types)) {
            $type = $request->input('type');
            $type = 'WITHDRAWAL';
            // $data['transactions'] = Transaction::where('user_id', auth()->id())->where('type', Transaction::)->latest()->get();
        }

        $data['transactions'] = Transaction::where('user_id', auth()->id())->latest()->get();
        return view('pages.transactions', compact('data'));
    }
}
