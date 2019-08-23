<?php

namespace App\Http\Controllers\Bunq;

use App\Http\Requests\Bunq\Payments\FilterRequest;
use App\Models\Payment;
use Carbon\Carbon;
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
     * @param FilterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(FilterRequest $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        return view('bunq.payments.filter')->with([
            'year'     => $year,
            'month'    => $month,
            'payments' => $this->filterPayments($year, $month),
        ]);
    }

    /**
     * @param $year
     * @param $month
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function filterPayments($year, $month)
    {
        // Create a date from the given year & month
        $date = Carbon::create($year, $month);

        return Payment::query()
            ->where('payment_at', '>=', $date->startOfMonth()->format('Y-m-d'))
            ->where('payment_at', '<=', $date->endOfMonth()->format('Y-m-d'))
            ->get();
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

