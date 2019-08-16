<?php
/*
|--------------------------------------------------------------------------
| bunq configuration file
|--------------------------------------------------------------------------
|
*/

return [

    // API key for api context
    'api_key' => env('BUNQ_API_KEY'),

    'oauth' => [
        // API details
        'authorize_uri' => 'https://oauth.bunq.com/auth',
        'token_uri'     => 'https://api.oauth.bunq.com/v1/token',
        'redirect_uri'  => env('BUNQ_REDIRECT_URI'),

        // Client details
        'client_id'     => env('BUNQ_CLIENT_ID'),
        'client_secret' => env('BUNQ_CLIENT_SECRET'),
    ],

];
