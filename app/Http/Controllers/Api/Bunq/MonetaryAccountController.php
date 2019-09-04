<?php

namespace App\Http\Controllers\Api\Bunq;

use bunq\Model\Generated\Endpoint\MonetaryAccount;

/**
 * Class MonetaryAccountController
 * @package App\Http\Controllers\Bunq
 */
class MonetaryAccountController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $monetaryAccountList = collect(MonetaryAccount::listing()->getValue());

        return response()->json($monetaryAccountList->toJson());
    }

}
