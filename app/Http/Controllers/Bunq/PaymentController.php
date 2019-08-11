<?php

namespace App\Http\Controllers\Bunq;

use bunq\Model\Generated\Endpoint\Payment;

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

        $payments = Payment::listing(24290);

        var_dump($payments);
        exit;


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
