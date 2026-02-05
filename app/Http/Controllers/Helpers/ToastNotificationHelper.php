<?php

namespace App\Http\Controllers\Helpers;

use App\Events\ToastNotificationBroadcast;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class ToastNotificationHelper extends Controller
{

    public static function notify($type = null,  $amount = null, $address = null)
    {
        return (new ToastNotificationHelper())->show($type,  $amount, $address);
    }

    public  function show($type = null,  $amount = null, $address = null)
    {
        $typeText = $this->getTypeText($type);
        $addressText = $this->getAddress($address);
        $amountText = $this->getAmountText($amount, $typeText['type']);

        // return $addressText;

        // $text = 'New ' . $typeText['text'] . ' ' . $amountText . ' ' . $addressText;
        $text = 'New ' . $typeText['text'] . ' ' . $amountText . ' ' . $addressText;

        ToastNotificationBroadcast::dispatch($text);
    }

    private function getAmountText($amount = null, $type)
    {

        switch ($type) {
            case Transaction::DEPOSIT:
                $limit['min'] = 10000;
                $limit['max'] = 20000000;
                break;
            case Transaction::WITHDRAWAL:
                $limit['min'] = 10000;
                $limit['max'] = 20000000;
                break;
        }




        if (!$amount) {
            return number_format(fake()->numberBetween($limit['min'], $limit['max']));
        } else {
            return number_format(((int) $amount));
        }
    }

    private function getTypeText($type)
    {

        $typeText = '';


        if (!$type) {
            $allowedTypes = [
                Transaction::DEPOSIT,
                Transaction::WITHDRAWAL,
                // Transaction::WON_PROMO_CODE,
            ];

            $randomIndex = array_rand($allowedTypes);
            $type = $allowedTypes[$randomIndex];
        }


        switch ($type) {
            case Transaction::DEPOSIT:
                $typeText = 'deposit';
                break;
            case Transaction::WITHDRAWAL:
                $typeText = 'withdrawal';
                break;
                // case Transaction::WON_PROMO_CODE:
                //     $typeText = 'promo code winning';
                //     break;
        }

        return ['text' => $typeText, 'type' => $type];
    }

    private function getAddress($address = null)
    {
        if (!$address) {
            $countryCode = '+255';
            $phoneCode = (string) fake()->boolean(70) ? '7' : '1';
            $starterNumber = (string) fake()->numberBetween(10, 99);
            $blur = '×××';
            $numberEnding =  (string) fake()->numberBetween(100, 999);
            $addressText = $countryCode . $phoneCode . $starterNumber . $blur . $numberEnding;
        } else {
            if (substr($address, 0, 1) === "0") {
                $countryCode = '+255';
                $address = substr($address, 1);
                $starterNumber = substr($address, 0, 3);
                $blur = '×××';
                $numberEnding = substr($address, -3);
                $addressText = $countryCode . $starterNumber . $blur . $numberEnding;
            } else {
                $addressText = $address;

                if (substr($address, 0, 1) === "+") {
                    $address = substr($address, 1);
                    $starterNumber = '+' . substr($address, 0, 6);
                    $blur = '×××';
                    $numberEnding = substr($address, -3);
                    $addressText = $starterNumber . $blur . $numberEnding;
                } else {
                    $starterNumber = '+' . substr($address, 0, 6);

                    $blur = '×××';
                    $numberEnding = substr($address, -3);
                    $addressText = $starterNumber . $blur . $numberEnding;
                }
            }
        }

        return $addressText;
    }

    public static function night()
    {

        $now = Carbon::now();
        $nightStart = Carbon::createFromTime(0, 0, 0);
        $nightEnd = Carbon::createFromTime(4, 0, 0)->addDay();
        return $now->between($nightStart, $nightEnd);
    }
}
