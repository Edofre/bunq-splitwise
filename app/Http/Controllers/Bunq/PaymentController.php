<?php

namespace App\Http\Controllers\Bunq;

use App\Models\Payment;
use Yajra\DataTables\DataTables;

/**
 * Class PaymentController
 * @package App\Http\Controllers\Bunq
 */
class PaymentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('bunq.payments.index')->with([

        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function data()
    {
        $payments = Payment::query()
            ->select([
                'id',
                'splitwise_id',
                'value',
                'currency',
                'description',
                'payment_at',
            ]);

        // Create datatables response
        $datatables = Datatables::of($payments)
            ->editColumn('action', function ($payment) {
                return view('bunq.payments.datatables._actions', ['payment' => $payment]);
            })
            ->rawColumns(['action']);

        return $datatables->make(true);
    }

    /**
     * @param Payment $payment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Payment $payment)
    {
        return view('bunq.payments.show')->with([
            'payment' => $payment,
        ]);
    }
}

