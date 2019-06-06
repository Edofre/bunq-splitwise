<?php

namespace App\Http\Controllers\Bunq;

/**
 * Class PaymentController
 * @package App\Http\Controllers\Bunq
 */
class PaymentController extends Controller
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
     * @param $week
     * @param $year
     */
    public function week($week, $year)
    {
        // /user/{userID}/monetary-account/{monetary-accountID}/payment
        var_dump($week, $year);
    }

    /**
     * @param $month
     * @param $year
     */
    public function month($month, $year)
    {
        // /user/{userID}/monetary-account/{monetary-accountID}/payment
        var_dump($month, $year);
    }
}
