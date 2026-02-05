<?php

namespace App\Policies;

use App\Models\Share;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SharePolicy
{
    public function update(User $user): bool
    {
        return in_array($user['email'], config('app.superadmins'));
    }

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
