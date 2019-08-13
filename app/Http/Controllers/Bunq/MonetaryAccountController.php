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
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function index()
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
