<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $appends = [
        'link',
        // 'completed'
    ];

    public function getLinkAttribute()
    {
        return  url('/register') . '?ref=' . $this->code;
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
