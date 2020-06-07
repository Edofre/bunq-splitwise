<?php

namespace App\Jobs\Splitwise;

use App\Models\Payment;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class SyncPayments
 * @package App\Jobs\Splitwise
 */
class SendPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    const SPLITWISE_FRIEND_USER_ID = 4050136;

    /** @var array */
    private $payments;

    /** @var integer */
    private $splitwiseUserId;
    /** @var string */
    private $splitwiseUserToken;

    /**
     * Create a new job instance.
     * @param integer $userId
     * @param string $splitwiseUserToken
     * @param array   $payments
     */
    public function __construct(int $splitwiseUserId, string $splitwiseUserToken, $payments)
    {
        $this->splitwiseUserId = $splitwiseUserId;
        $this->splitwiseUserToken = $splitwiseUserToken;
        $this->payments = $payments;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        // SELECT * FROM `payments`
        // WHERE `payment_at` >= '2019-09-15 00:00:00'
        // AND `payment_at` < '2020-10-01 00:00:00'

        foreach ($this->payments as $paymentId => $payment) {
            $paymentModel = Payment::find($paymentId);

            try {
                $client = new GuzzleClient([
                    'base_uri' => config('splitwise.base_uri'),
                ]);

                // Get values, split value in two for both parties
                $splitValue = abs(round($payment['value'] / 2, 2));
                $value = $splitValue * 2;

                $data = [
                    'currency_code' => "EUR",
                    'users'         => [
                        ['user_id' => $this->userId, 'paid_share' => $value, 'owed_share' => $splitValue],
                        ['user_id' => self::SPLITWISE_FRIEND_USER_ID, 'paid_share' => 0, 'owed_share' => $splitValue],
                    ],
                    'payment'       => false,
                    'cost'          => $value,
                    'description'   => $payment['description'],
                ];

                // Create the expense @ Splitwise
                $response = $client->post('create_expense', [
                    'form_params' => $data,
                    'headers'     => [
                        'Authorization' => 'Bearer ' . decrypt($this->splitwiseUserToken),
                    ],
                ]);

                $response = json_decode($response->getBody()->getContents());
                // Get our created expense
                $expense = $response->expenses[0] ?? null;

                if (!is_null($expense)) {
                    $paymentModel->update([
                        'splitwise_id' => $expense->id,
                    ]);
                } else {
                    \Log::channel('splitwise')->error('Could not create expense', ['response' => $response]);
                }
            } catch (\Exception $exception) {
                \Log::channel('splitwise')->error('Could not create expense', ['exception' => $exception]);
            }
        }
    }
}
