<?php

return [
    'trial_days' => 14,

    'plans' => [
        'price_1GxwMfGlrejN28VyVIcTWpGY' => 'Pro — $10',
        'price_1GxwdjGlrejN28VyS5o9c2YP' => 'Premium — $20',
    ],

    'cancelation_reasons' => [
        'Too expensive',
        'Lacks features',
        'Not what I expected',
    ],

    'stripe_key' => env('STRIPE_KEY'),
    'stripe_secret' => env('STRIPE_SECRET'),
];
