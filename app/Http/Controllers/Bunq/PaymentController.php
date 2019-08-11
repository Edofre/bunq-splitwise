<?php

namespace App\Http\Controllers\Bunq;

use bunq\Model\Generated\Endpoint\Payment;
use Carbon\Carbon;

/**
 * Class PaymentController
 * @package App\Http\Controllers\Bunq
 */
class PaymentController extends Controller
{
    /** @var string */
    const TYPE_SAVINGS = 'SAVINGS';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $account
     * @param $week
     * @param $year
     */
    public function week($account, $week, $year)
    {
        $listing = Payment::listing($account, [
            'count' => 200,
        ]);
        // TODO, pagination, fetch all? What's handy?, check after 200 if week / year is still in payments?
        // TODO, maybe make payment sync function? To fetch all payments? We can then later sync them?
        // https://doc.bunq.com/#/pagination

        // Let's do some filtering
        $payments = collect($listing->getValue());

        $filtered = $payments->filter(function ($value) {
            var_dump($value);

            exit;
        });

        var_dump($filtered);
        exit;

        var_dump($week, $year);
    }

    /**
     * @param $account
     * @param $month
     * @param $year
     */
    public function month($account, $month, $year)
    {
        $listing = Payment::listing($account, [
            //            'count' => 200,
            'count' => 10,
        ]);
        // TODO, pagination, fetch all? What's handy?, check after 200 if week / year is still in payments?
        // TODO, maybe make payment sync function? To fetch all payments? We can then later sync them?

        // Let's do some filtering
        $payments = collect($listing->getValue());

        $date = Carbon::create($year, $month);
        $start = $date->startOfMonth()->format('Y-m-d H:i:s.u');
        $end = $date->endOfMonth()->format('Y-m-d H:i:s.u');

        // Filter our payments
        $filtered = $payments->filter(function ($payment) use ($start, $end) {

            return
                $payment->getType() !== self::TYPE_SAVINGS &&
                $payment->getCreated() >= $start &&
                $payment->getCreated() <= $end;
        });

        foreach ($filtered as $payment) {
            var_dump($payment->getDescription());
            $amount = $payment->getAmount();

            var_dump($amount->getValue());
            var_dump(abs($amount->getValue()));

            var_dump($payment);
            exit;
        }
    }

}
