<?php 

return [
    /*
    |--------------------------------------------------------------------------
    | ExchangeRate-API Latest Rates URL
    |--------------------------------------------------------------------------
    |
    | Base API url for latest rates (by ExchangeRate-API): https://www.exchangerate-api.com/
    |
    */
    'exchange_rate_latest_url' => env('EXCHANGE_RATES_LATEST_URL', 'https://v6.exchangerate-api.com/v6/%api-key%/latest/%base_currency%'),

    /*
    |--------------------------------------------------------------------------
    | ExchangeRate-API API KEY
    |--------------------------------------------------------------------------
    |
    | Create account at https://www.exchangerate-api.com/ and get the API KEY.
    | Put APP ID in EXCHANGE_RATES_API_KEY .env variable
    |
    */
    'exhange_rates_api_key' => env('EXCHANGE_RATES_API_KEY', '')
];