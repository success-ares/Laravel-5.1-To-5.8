<?php

return [

    // Account
    'apiKey'        => env('EWAY_API_KEY'),
    'apiPassword'   => env('EWAY_API_PASS'),
    'apiEndpoint'   => env('EWAY_API_ENDPOINT', 'MODE_PRODUCTION'),    // Use MODE_PRODUCTION when you go live
    'encryptKey'    => env('EWAY_ENCRYPT_KEY')
];
