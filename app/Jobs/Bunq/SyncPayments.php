<?php

namespace App\Jobs\Bunq;

use bunq\Model\Generated\Endpoint\MonetaryAccount;
use bunq\Model\Generated\Endpoint\Payment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class SyncPayments
 * @package App\Jobs\Bunq
 */
class SyncPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    const BUNQ_PAYMENT_LIMIT = 200;

    /** @var MonetaryAccount */
    private $monetaryAccount;
    /** @var int */
    private $monetaryAccountId;

    /**
     * Create a new job instance.
     * @param $monetaryAccountId
     */
    public function __construct($monetaryAccountId)
    {
        // Store our id for safe keeping
        $this->monetaryAccountId = $monetaryAccountId;

        // Let's make sure the monetary accounts exists
        try {
            $this->monetaryAccount = MonetaryAccount::get($monetaryAccountId)->getValue();
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $this->loopPayments();
    }

    /**
     * @param null $olderId
     */
    private function loopPayments($olderId = null)
    {
        $parameters = [
            'count' => self::BUNQ_PAYMENT_LIMIT,
        ];

        if (!is_null($olderId)) {
            $parameters['older_id'] = $olderId;
        }

        // Fetch all the payment listings
        $listing = Payment::listing($this->monetaryAccountId, $parameters);

        foreach ($listing->getValue() as $payment) {
            // Get the amount from the payment
            $amount = $payment->getAmount();

            $attributes = [
                'bunq_monetary_account_id' => $payment->getMonetaryAccountId(),
                'bunq_payment_id'          => $payment->getId(),
                'value'                    => $amount->getValue(),
                'currency'                 => $amount->getCurrency(),

                'description' => $payment->getDescription(),
                'type'        => $payment->getType(),
                'sub_type'    => $payment->getSubType(),
                'payment_at'  => Carbon::createFromFormat('Y-m-d H:i:s.u', $payment->getCreated()),
            ];

            \App\Models\Payment::create($attributes);
        }

        // TODO, for now we just fetch the last 200 transactions, should not have more than 200 in a month anyway
        // $pagination = $listing->getPagination();
        // if (!is_null($pagination->getOlderId())) {
        //   $this->loopPayments($pagination->getOlderId());
        // }
    }
}
