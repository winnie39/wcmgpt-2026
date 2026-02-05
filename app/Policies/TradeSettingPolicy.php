<?php

namespace App\Policies;

use App\Models\User;

class TradeSettingPolicy
{
    public function delete(User $user): bool
    {
        return in_array($user['email'], config('app.superadmins'));
    }

    public function deleteAny(User $user): bool
    {
        return in_array($user['email'], config('app.superadmins'));
    }


    public function create(User $user): bool
    {
        return in_array($user['email'], config('app.superadmins'));
    }
}
