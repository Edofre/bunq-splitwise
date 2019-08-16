<?php

namespace App\Http\Controllers\Bunq;

use bunq\Context\ApiContext;
use bunq\Context\BunqContext;
use bunq\Util\BunqEnumApiEnvironmentType;

/**
 * Class ApiContextController
 * @package App\Http\Controllers\Bunq
 */
class ApiContextController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        // Don't instantiate bunq api context, we're using oauth2 here
        // parent::__construct();

        // Make sure oauth configuration is set
        foreach ([
            config('bunq.oauth.authorize_uri'),
            config('bunq.oauth.token_uri'),
            config('bunq.oauth.redirect_uri'),
            config('bunq.oauth.client_id'),
            config('bunq.oauth.client_secret'),
        ] as $config) {
            if (is_null($config)) {
                abort(500, 'Please add all the bunq configuration entries in config/bunq.php');
            }
        }
    }

    /**
     * @throws \bunq\Exception\BunqException
     */
    public function create()
    {
        $environmentType = BunqEnumApiEnvironmentType::PRODUCTION();
        $apiKey = config('bunq.api_key');
        $deviceDescription = 'bunq-splitwise';
        $permittedIps = [];

        $apiContext = ApiContext::create(
            $environmentType,
            $apiKey,
            $deviceDescription,
            $permittedIps
        );

        BunqContext::loadApiContext($apiContext);

        $fileName = storage_path('bunq/bunq.conf');
        $apiContext->save($fileName);
    }

}
