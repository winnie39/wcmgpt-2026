<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\ReferralLevel;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $referrals = Referral::has('user')->where('referrer_id', auth()->id())->get();

        $referralLevels = ReferralLevel::orderBy('level', 'asc')->get();

        return view('pages.team', compact('referrals', 'referralLevels'));
    }
}
