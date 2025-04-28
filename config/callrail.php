<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CallRail API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for CallRail.
    |
    | To learn more: https://apidocs.callrail.com/
    |
    */

    'api_url' => env('CALLRAIL_API_URL', 'https://api.callrail.com/'),

    'version' => 'v3',

    'account_id' => env('CALLRAIL_ACCOUNT_ID',''),

    'token' => env('CALLRAIL_TOKEN_ID',''),
];
