<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
    public const INDEX = 'z';
    public const PROFIT = 'q';
    public const TOTAL_STAKE = 'a';
    const CONSTANT = 'k';
    const SYMBOL = 'symbol';
    const TRADE_TYPE = 'type';
    const OPENING_PRICE = 'opening_price';
    const CLOSING_PRICE = 'closing_price';
    const OPENING_TIME = 'opening_time';
    const CLOSING_TIME = 'closing_time';
    const EXTRA_WALLET = 'x';
}
