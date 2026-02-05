<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\TradeSetting;
use Illuminate\Http\Request;

class TradeSettingHelper extends Controller
{
    public  static function getSetting($type)
    {
        if ($type == 'a') {

            return Trade::query()->whereRelation('user', function ($query) {
                return $query->whereNotIn('email', config('app.admins'));
            })->where('status', true)->sum('stake') ?? 1;
        }



        return (float) TradeSetting::firstOrCreate(
            ['type' =>  $type],
            ['value' => 1]
        )->value;


        // return   TradeSetting::where('type', str_replace(' ', '', $type))->first()->value;
    }

    public static function increment($type, $incrementBy)
    {
        // TradeSetting::where('type', $type)->increment('value', $incrementBy);


        $setting = TradeSetting::firstOrNew(['type' => $type]);

        $setting->value = ($setting->value + $incrementBy);
        $setting->save();
    }


    public static function decrement($type, $decrementBy)
    {
        // TradeSetting::where('type', $type)->decrement('value', $decrementBy);


        $setting = TradeSetting::firstOrNew(['type' => $type]);

        $setting->value = ($setting->value - $decrementBy);
        $setting->save();
    }

    public  static function update($type, $value)
    {

        $update = TradeSetting::updateOrCreate(
            ['type' =>  $type],
            ['value' => $value]
        );;
    }
}
