<?php

namespace App\Jobs\Bunq;

use bunq\Model\Generated\Endpoint\MonetaryAccount;
use bunq\Model\Generated\Endpoint\Payment;
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
    const BUNQ_PAYMENT_LIMIT = 10;

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
        // Fetch all the payment listings
        $listing = Payment::listing($this->monetaryAccountId, [
            'count' => self::BUNQ_PAYMENT_LIMIT,
        ]);

        foreach ($listing->getValue() as $l) {
            var_dump($l);
        }

        var_dump($listing);

//        "newer_url": "/v1/user/1/monetary-account/1/payment?count=25&newer_id=249",
        exit;
    }

    private function fetchPayments($newerId = null) {

    }
}
