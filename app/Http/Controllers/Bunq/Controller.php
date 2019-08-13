<?php

namespace App\Http\Controllers\Bunq;

use App\Http\Controllers\Controller as BaseController;
use bunq\Context\ApiContext;
use bunq\Context\BunqContext;

/**
 * Class Controller
 * @package App\Http\Controllers\Bunq
 */
class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
        $configFile = storage_path('bunq/bunq.conf');

        // Make sure the config file exists, otherwise throw an exception
        if (!file_exists($configFile)) {
            throw new \Exception('Make sure you create the bunq api context! Read this: https://github.com/bunq/sdk_php#creating-an-api-context-using-bunq-install-interactive-script');
        }

        // Load bunq api context
        $apiContext = ApiContext::restore($configFile);
        BunqContext::loadApiContext($apiContext);
    }

}
