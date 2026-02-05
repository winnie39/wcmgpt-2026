<?php

namespace App\Http\Controllers\Helpers;


use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralLevel;
use App\Models\TradeSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralHelper extends Controller
{
    private $referrerId;
    private $referrers = [];
    private $amount;
    private $refFreeSpinPercentage;
    private $userId;
    private $user;
    public function newRef($id, $amount)
    {

        $this->user = User::find($id);

        $this->userId = $id;
        $this->amount = $amount;
        $this->addCompleted();
        $this->getReferrers();
        $this->payReferrers();
        return true;
    }

    private function addCompleted()
    {
        Referral::query()->where('user_id', $this->userId)->update([
            'completed' => true,
        ]);
    }

    private function getReferrers()
    {
        $refLevels = $this->getAllowedReferralLevels();
        foreach ($refLevels as $refLevel) {
            $level = $refLevel->level;
            if ($level === 1) {
                $referrerId = Referral::where('user_id', $this->userId)->first()->referrer_id;
                if ($referrerId !== null) {
                    $this->referrerId = $referrerId;
                    array_push($this->referrers, ["level" => $level, "id" => $referrerId]);
                } else {
                    return true;
                }
            } else {
                $referrerId = Referral::where('user_id', $this->referrerId)->first()->referrer_id;
                if ($referrerId !== null) {
                    $this->referrerId = $referrerId;
                    array_push($this->referrers, ["level" => $level, "id" => $referrerId]);
                } else {
                    return true;
                }
            }
        }
    }



    private function payReferrers()
    {
        $referrers = $this->referrers;
        $remainingAmount  = $this->amount;
        $addedAdmount = 0;
        foreach ($referrers as $referrer) {
            $refCommission = (float) ReferralLevel::where('level', $referrer['level'])->first()->rate;
            $refAmount = ($refCommission * $this->amount);

            Wallet::where('user_id', $referrer['id'])->increment('referral_commission', $refAmount);
            $remainingAmount -= $refAmount;
            Transaction::create([
                'amount' => $refAmount,
                'status' => Transaction::COMPLETED,
                'type' => Transaction::REFERRALS,
                'code' => Str::random(8),
                'description' => 'Level ' . $referrer['level'] . 'referral commission from ' .  $this->user->name,
                'method' => 'REFERRAL',
                'address' => 'REFERRALS',
                'user_id' => $referrer['id'],
            ]);

            $addedAdmount += $refAmount;
        }

        TradeSettingHelper::increment(TradeSetting::INDEX, $remainingAmount);
        TradeSettingHelper::increment(TradeSetting::EXTRA_WALLET, $remainingAmount * 0.85);
    }

    private function getAllowedReferralLevels()
    {
        return ReferralLevel::orderBy('level', 'asc')->get();
    }
}
