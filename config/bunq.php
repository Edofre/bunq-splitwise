<?php
/*
|--------------------------------------------------------------------------
| bunq configuration files
|--------------------------------------------------------------------------
|
*/

return [

    'oauth' => [
        // API details
        'url'           => 'https://oauth.bunq.com/auth',
        'url_token'     => 'https://api.oauth.bunq.com/v1/token',
        'redirect_uri'  => env('BUNQ_REDIRECT_URI'),

        // Client details
        'client_id'     => env('BUNQ_CLIENT_ID'),
        'client_secret' => env('BUNQ_CLIENT_SECRET'),
    ],
];
