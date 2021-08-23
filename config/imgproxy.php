<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable imgproxy
    |--------------------------------------------------------------------------
    |
    | Determines if images should be served through the imgproxy server
    |
    */

    'enabled' => env('IMGPROXY_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Imgproxy server host
    |--------------------------------------------------------------------------
    |
    | Host of the imgproxy server
    |
    */

    'host' => env('IMGPROXY_HOST', 'localhost:8080'),

    /*
    |--------------------------------------------------------------------------
    | Imgproxy key and salt
    |--------------------------------------------------------------------------
    |
    | Key and Salt are used to create a signature for all proxied requests.
    | This should be implemented because of the security reasons - only our servers can generate proper URLs and no one else can use imgproxy server
    | If signature is not correct, error 403 is received
    |
    */

    'key' => env('IMGPROXY_KEY', '514d4c4a38644e6f584c636b6f6d346f4e674c5a'), // string: QMLJ8dNoXLckom4oNgLZ; hex: 514d4c4a38644e6f584c636b6f6d346f4e674c5a
    'salt' => env('IMGPROXY_SALT', '3678483379414452545950396c39365748496237'), // string: 6xH3yADRTYP9l96WHIb7; hex: 3678483379414452545950396c39365748496237

];
