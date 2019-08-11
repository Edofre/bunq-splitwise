<?php
/*
|--------------------------------------------------------------------------
| bunq configuration files
|--------------------------------------------------------------------------
|
*/

return [

    'base_uri' => 'https://www.splitwise.com/api/v3.0/',

    'oauth' => [
        // API details
        'authorize_uri' => 'https://secure.splitwise.com/oauth/authorize',
        'token_uri'     => 'https://secure.splitwise.com/oauth/token',
        'redirect_uri'  => env('SPLITWISE_REDIRECT_URI'),

        // Client details
        'client_id'     => env('SPLITWISE_CLIENT_ID'),
        'client_secret' => env('SPLITWISE_CLIENT_SECRET'),
    ],
];
