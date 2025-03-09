<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Explanations
    |--------------------------------------------------------------------------
    |
    | environment value will be (`stage` or `production`)
    |
    */
    'environment' => env('FIB_PAYOUT_ENV', 'staging'),
    'stage_url' => env('FIB_PAYOUT_STAGE_URL', 'https://fib.stage.fib.iq'),
    'prod_url' => env('FIB_PAYOUT_PROD_URL', 'https://fib.prod.fib.iq'),
    'client_id' => env('FIB_PAYOUT_CLIENT_ID'),
    'client_secret' => env('FIB_PAYOUT_CLIENT_SECRET'),
];