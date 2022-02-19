<?php


namespace App\Services;


use Carbon\Carbon;
use GuzzleHttp\Client;

class CurrencyRates
{
    public static function getRates()
    {
        $baseCurrency = CurrencyConversion::getBaseCurrency();
        $url = config('currency_rates.api_url') . $baseCurrency->code;
        $client = new Client();
        $response = $client->request('get', $url);
        if (!$response->getStatusCode() === 200) {
            throw new \Exception('There is a problem with currency rate services');
        }
        $rates = json_decode($response->getBody()->getContents(), true)['data'];
        foreach (CurrencyConversion::getCurrencies() as $currency) {
            if (!$currency->isMain()) {
                if (!isset($rates[$currency->code])) {
                    throw new \Exception('There is a problem with currency rate services' . $currency->code);
                } else {
                    $currency->update(['rate' => $rates[$currency->code]]);
                    $currency->touch();
                }
            }
        }

    }
}
