<?php

namespace App\Http\Controllers\Api\Bunq;

use App\Http\Controllers\Api\Controller as BaseController;
use bunq\Context\ApiContext;
use bunq\Context\BunqContext;

/**
 * Class Controller
 * @package App\Http\Controllers\Api\Bunq
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
        // We can't get the user from the auth in a regular way
        $this->middleware(function ($request, $next) {
            // Get the api context for this user & make sure the file exists
            $configFile = storage_path("bunq/1.conf"); // TODO HARDCODED

            try {
                // Load bunq api context
                $apiContext = ApiContext::restore($configFile);
                BunqContext::loadApiContext($apiContext);
            } catch (\Exception $exception) {
                \Log::channel('bunq')->error('Could not restore api context', ['exception' => $exception]);

                abort(500, 'Could not restore api context');
            }

            return $next($request);
        });
    }
}
