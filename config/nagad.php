<?php

return [
    'sandbox_mode' => env('NAGAD_MODE', 'live'),
    'merchant_id' => env('NAGAD_MERCHANT_ID','689590404235065'),
    'merchant_number' => env('NAGAD_MERCHANT_NUMBER','01959040423'),
    'callback_url' => env('NAGAD_CALLBACK_URL', env('APP_URL').'/nagad/callback')
];
