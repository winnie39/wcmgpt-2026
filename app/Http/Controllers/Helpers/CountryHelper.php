<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Throwable;

class CountryHelper extends Controller
{

    public function __invoke()
    {
        $url = 'https://restcountries.com/v3.1/name/america';
        $response =   Http::get($url)->json();
    }

    public function setCountries()
    {

        $url = "https://restcountries.com/v3.1/all?fields=name,currencies,idd";
        $response =  Http::get($url)->json();


        try {
            foreach ($response as $country) {

                $countryName = $country['name']['common'];
                // Create country model
                $setCountry = Country::query()->create([
                    'name' => $countryName,
                ]);
                // set country currency
                foreach ($country['currencies'] as $currency => $details) {
                    if (strlen($currency) === 3) {
                        Country::where('name', $countryName)->update([
                            'currency' => $currency
                        ]);
                        break;
                    }
                }
                // Set country codes

                try {
                    $idd = $country['idd'];
                    $root = $idd['root'];
                    $suffixes = $idd['suffixes'];
                    $code = count($suffixes) === 1 ? $root . $suffixes[0] : $root;
                    Country::where('name', $countryName)->update([
                        'country_code' => $code,
                    ]);
                } catch (Throwable $e) {
                }
            }



            $this->setRates();
            $this->setSiteCurrency();
            $countries = Country::orderBy('name', 'asc')->get();
            Cache::put('countries', $countries);
            return true;
        } catch (Throwable $e) {
            report($e);
            $countries = Country::get();
            $cache = Cache::put('countries', $countries);
            return true;
        }
    }

    public static function setCache()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        Cache::put('countries', $countries);
        return true;
    }

    public static function getCountryCurrency($country)
    {
        return Country::query()->where('name', 'like', $country)->first()->currency;
    }

    public static function getAllCountries()
    {

        $set = Request::input('config');

        if ($set) {
            Country::query()->truncate();
            Cache::forget('countries');
        }

        $countries = Country::orderBy('name', 'asc')->get();



        if ($countries->count() > 50) {
            return  $countries->where('active', true);
        } else {
            (new self)->setCountries();
            return Cache::get('countries');
        }
    }

    private function setRates()
    {
        $url = "https://api.coinbase.com/v2/exchange-rates?currency=KES";
        $response =  Http::get($url)->json();

        foreach ($response as $data) {
            foreach ($data['rates'] as $currency => $rate) {

                Country::where('currency', 'like', $currency)->update([
                    'kes_rate' => round($rate, 6),
                ]);
            }
        }
    }

    private function setSiteCurrency()
    {
        Country::query()->create([
            'name' => 'Iotron',
            'kes_rate' => 0.926277,
            'currency' => 'ERC',
            'country_code' => 'SITE'
        ]);
    }

    public function setUserCountries()
    {


        $kenya = Country::where('name', 'like', 'Kenya')->first();
        $uganda = Country::where('name', 'like', 'Uganda')->first();

        if ($kenya) {
            User::where('phone', 'like', '%+254%')->update([
                'country_id' => $kenya->id,
            ]);
        }

        if ($uganda) {

            User::where('phone', 'like', '%+256%')->update([
                'country_id' => $uganda->id,
            ]);
        }

        return true;
    }

    public static function siteCurrency()
    {
        return Country::query()->where('name', 'like', 'iotron')->first()->currency;
    }

    public static function convert($from, $to, $amount, $decimals = 2)
    {
        $fromRate = Country::where('currency', 'like', $from)->first()->kes_rate ?? 0;
        $toRate = Country::where('currency', 'like', $to)->first()->kes_rate ?? 0;


        $result = ($amount * $toRate) / $fromRate;

        return round($result, $decimals);
    }

    public static function getCurrencyConstant()
    {
        $url = "https://api.coinbase.com/v2/exchange-rates?currency=USD";
        $response =  Http::get($url)->json();
        $rates = $response['data']['rates'];

        $currency = auth()->user()->configs->currency;

        return (object) [
            'constant' => (float) $rates[$currency] ?? 1,
            'currency' => $currency  ?? '$',
            'code' => $currency ?? '$',
            'decimals' =>    $currency  == 'USD' ? 4 : 2
        ];
    }

    public static function convertCurrency($amount, $from, $to)
    {
        $url = "https://api.coinbase.com/v2/exchange-rates?currency=" . strtoupper($from);
        $response =  Http::get($url)->json();
        $rates = $response['data']['rates'];

        return (object) [
            'constant' => (float) $rates[strtoupper($to)] ?? 1,
            'currency' => $to,
            'amount' => $amount * (float) $rates[strtoupper($to)]
        ];
    }

    public static function getRates()
    {
        $url = "https://api.coinbase.com/v2/exchange-rates?currency=" . config('app.currency');
        $response =  Http::get($url)->json();
        $rates = $response['data']['rates'];
        return $rates;
    }
}
