<?php

namespace App\Http\Controllers\Bunq;

use App\Jobs\Bunq\SyncPayments;

/**
 * Class PaymentController
 * @package App\Http\Controllers\Bunq
 */
class PaymentController extends Controller
{

    /**
     * @param $monetaryAccountId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sync($monetaryAccountId)
    {
        // Dispatch the job that will sync ALL payments, could take a while
        SyncPayments::dispatch($monetaryAccountId);

        flash(__('bunq.payments_currently_syncing'))->success();
        return redirect('bunq.monetary-accounts.payments.list', ['monetaryAccountId' => $monetaryAccountId]);
    }


    public function list($monetaryAccountId)
    {
        var_dump($monetaryAccountId);
        exit;

        return view('bunq.payments.list')->with([
            'payments' => [],
        ]);
    }
}
