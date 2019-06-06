<?php

namespace App\Http\Controllers;

/**
 * Class MonetaryAccountController
 * @package App\Http\Controllers
 */
class MonetaryAccountController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($userId) {
        // /user/{userID}/monetary-account
    }

    /**
     * @param $userId
     */
    public function show($userId, $itemId)
    {
        // /user/{userID}/monetary-account/{itemId}
    }

}
