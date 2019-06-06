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
     */
    public function __construct()
    {
        // Load bunq api context
        $apiContext = ApiContext::restore(base_path('bunq.conf'));
        BunqContext::loadApiContext($apiContext);
    }

}
