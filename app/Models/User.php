<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        $admins = config('app.admins');
        $additionalAdmins = [];
        $allAdmins = array_merge($admins, $additionalAdmins);
        return  in_array(auth()->user()->email, $allAdmins);
    }

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'verified'
    ];

    public function getVerifiedAttribute()
    {
        return $this->kyc->verified;
    }


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tradeLogs()
    {
        return $this->hasMany(TradeLog::class);
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function referral()
    {
        return $this->hasOne(Referral::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function trade()
    {
        return $this->hasOne(Trade::class);
    }
}
