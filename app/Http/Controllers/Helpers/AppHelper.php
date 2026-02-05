<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppHelper extends Controller
{
    public static function error($error)
    {
        return response($error, 433);
    }

    public static function success($success)
    {
        return response($success, 233);
    }
}
