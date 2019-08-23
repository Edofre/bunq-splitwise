<?php

namespace App\Http\Controllers\Bunq;

use App\Jobs\Bunq\SyncPayments;
use App\Models\Payment;
use bunq\Model\Generated\Endpoint\MonetaryAccount;
use Yajra\DataTables\DataTables;

/**
 * Class MonetaryAccountController
 * @package App\Http\Controllers\Bunq
 */
class MonetaryAccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $monetaryAccountList = collect(MonetaryAccount::listing()->getValue());

        //        // Debug
        //        foreach ($monetaryAccountList as $monetaryAccount) {
        //            var_dump($monetaryAccount);
        //            var_dump($monetaryAccount->getReferencedObject()->getId());
        //            var_dump($monetaryAccount->getReferencedObject()->getDescription());
        //            var_dump($monetaryAccount->getReferencedObject()->getBalance()->getValue());
        //            echo '<hr/><hr/>';
        //        }
        //        exit;

        return view('bunq.monetary-accounts.index')->with([
            'monetaryAccounts' => $monetaryAccountList,
        ]);
    }

    /**
     * @param $monetaryAccountId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($monetaryAccountId)
    {
        $monetaryAccount = MonetaryAccount::get($monetaryAccountId)->getValue();

        return view('bunq.monetary-accounts.show')->with([
            'monetaryAccountId' => $monetaryAccountId,
            'monetaryAccount'   => $monetaryAccount,
        ]);
    }

    /**
     * @param $monetaryAccountId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sync($monetaryAccountId)
    {
        // Dispatch the job that will sync ALL payments, could take a while
        SyncPayments::dispatch($monetaryAccountId);

        flash(__('bunq.payments_currently_syncing'))->success()->important();
        return redirect()->route('bunq.monetary-accounts.show', ['monetaryAccountId' => $monetaryAccountId]);
    }

    /**
     * @param $monetaryAccountId
     * @return mixed
     * @throws \Exception
     */
    public function paymentData($monetaryAccountId)
    {
        $payments = Payment::query()
            ->select([
                'id',
                'splitwise_id',
                'value',
                'currency',
                'description',
                'payment_at',
            ])
            ->where('bunq_monetary_account_id', $monetaryAccountId);

        // Create datatables response
        $datatables = Datatables::of($payments)
            ->editColumn('action', function ($payment) {
                return view('bunq.payments.datatables._actions', ['payment' => $payment]);
            })
            ->rawColumns(['action']);

        return $datatables->make(true);
    }

}
