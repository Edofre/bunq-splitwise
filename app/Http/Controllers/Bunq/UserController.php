<?php

namespace App\Http\Controllers\Bunq;

/**
 * Class UserController
 * @package App\Http\Controllers\Bunq
 */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $week
     * @param $year
     */
    public function index()
    {
        // /user
    }

    /**
     * @param $userId
     */
    public function show($userId) {
        // /user/{itemId}
        var_dump($userId);
        exit;
    }

}
