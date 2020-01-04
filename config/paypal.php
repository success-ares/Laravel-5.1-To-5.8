<?php

return [

    // Account paypal
    'account' => [

        'client_id' => env('PAYPAL_CLIENT_ID', 'AdDHnGJMt3SQR0OpfiT46uAhKSS5SNiczXWy2u4acIMQj1qGXNmFXtTspZXOBMemYeS2EkKm0fKEtC1K'),
        'secret'    => env('PAYPAL_CLIENT_SECRET', 'EEvibAT48wn-RIskO5ewVTK5IZb89IsiU4eh_UwKArjbEr_-aYL5DS2DX2ChTkurjnNLz9RWUyAWmM2z'),

    ],

    // paypal configuration
    'settings'  => [

        'mode'                      => env('PAYPAL_MODE', 'sandbox'),
        'service.EndPoint'          => 'https://api.sandbox.paypal.com',
        'http.CURLOPT_CONNECTTIMEOUT'=> env('PAYPAL_HTTP_TIMEOUT', 30),
        'log.LogEnabled'            => env('PAYPAL_LOG_ENABLED', false),
        'log.FileName'              => env('PAYPAL_LOG_FILE_NAME', storage_path('logs/paypal.log')),
        'log.LogLevel'              => env('PAYPAL_LOG_LEVEL', 'FINE'),
        'cache.enabled'             => true,
        'cache.FileName'            => storage_path('framework/cache/auth.cache'),
    ],

    // currency
    'currency'  => env('PAYPAL_CURRENCY', 'RUB'),
];