<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHelper extends Controller
{
    static function isAdmin()
    {
        return in_array(auth()->user()->email, config('app.admins'));
    }
}
