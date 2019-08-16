<?php

namespace App\Http\Controllers\Bunq;

use bunq\Model\Generated\Endpoint\MonetaryAccount;

/**
 * Class MonetaryAccountController
 * @package App\Http\Controllers\Bunq
 */
class MonetaryAccountController extends Controller
{
    /**
     *
     */
    public function list()
    {
        $monetaryAccountList = collect(MonetaryAccount::listing()->getValue());
        return $monetaryAccountList->toJson();
    }

    /**
     * @param $itemId
     * @return string
     */
    public function show($itemId)
    {
        $monetaryAccount = collect(MonetaryAccount::get($itemId)->getValue());
        return $monetaryAccount->toJson();
    }

}
