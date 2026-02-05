<?php

namespace App\Models;

use App\Http\Controllers\Helpers\CountryHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $rates;
    protected $appends = [
        'status_text',
        'type_text',
        'amount_before_deduction',
    ];

    public function getAmountBeforeDeductionAttribute($value)
    {


        if ($value > 0) {
            return $value;
        }


        if ($this->type == Transaction::WITHDRAWAL) {
            return ($this->amount / 0.925);
        }

        return $this->amount;
    }

    public function getStatusTextAttribute()
    {
        if (!$this->status) {
            return 'UNKNOWN';
        }

        if ($this->status == 1) {
            return 'PENDING';
        } else if ($this->status == 2) {
            return 'SUCCESS';
        } else if ($this->status == 3) {
            return 'PENDING';
        }
    }

    public function getTypeTextAttribute()
    {

        if (!$this->type) {
            return 'UNKNOWN';
        }


        if ($this->type == 1) {
            return 'DEPOSIT';
        } else if ($this->type == 2) {
            return 'WITHDRAWAL';
        } else if ($this->type == 4) {
            return 'WELCOME BONUS';
        } else if ($this->type == 5) {
            return 'P2P TRANSFER SENT';
        } else if ($this->type == 3) {
            return 'INVESTMENT';
        } else if ($this->type == 6) {
            return 'REFERRAL';
        } else if ($this->type == 5) {
            return 'P2P TRANSFER SENT';
        } else if ($this->type == 7) {
            return 'P2P TRANSFER SENT';
        }
    }


    public const COMPLETED = 2;
    public const PENDING = 1;
    public const FAILED = 0;
    public const UNCOMPLETED = 3;

    public const DEPOSIT = 1;
    public const WITHDRAWAL = 2;
    public const INVESTMENT = 3;
    public const SIGNUP_BONUS = 4;
    public const P2P_TRANSFER_SEND = 5;
    public const P2P_TRANSFER_RECEIVE = 7;
    public const REFERRALS = 6;
    public const P2P_TRANSFER_PROFIT = 8;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
