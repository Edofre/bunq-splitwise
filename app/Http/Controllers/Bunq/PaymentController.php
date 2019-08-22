<?php

namespace App\Http\Controllers\Bunq;

use App\Jobs\Bunq\SyncPayments;
use App\Models\Payment;
use Yajra\DataTables\DataTables;

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

        flash(__('bunq.payments_currently_syncing'))->success()->important();
        return redirect()->route('bunq.monetary-accounts.payments.list', ['monetaryAccountId' => $monetaryAccountId]);
    }

    /**
     * @param $monetaryAccountId
     * @return mixed
     * @throws \Exception
     */
    public function data($monetaryAccountId)
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

        $datatables = Datatables::of($payments);
        //            TODO
        //            ->editColumn('action', function ($payment) {
        //                return view('bunq.payments.columns._index', ['payment' => $payment]);
        //            })
        //            ->rawColumns(['action']);
        return $datatables->make(true);
    }

    /**
     * @param $monetaryAccountId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list($monetaryAccountId)
    {
        var_dump($monetaryAccountId);
        exit;

        return view('bunq.payments.list')->with([
            'payments' => [],
        ]);
    }
}
