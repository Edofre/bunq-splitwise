<?php

namespace App\Http\Controllers\Bunq;

use App\Http\Requests\Bunq\Payments\FilterRequest;
use App\Http\Requests\Bunq\Payments\ProcessRequest;
use App\Models\Payment;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
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
        $filterAlreadySent = $request->get('filter_already_sent', true);

        return view('bunq.payments.filter')->with([
            'year'              => $year,
            'month'             => $month,
            'filterAlreadySent' => $filterAlreadySent,
            'payments'          => $this->filterPayments($year, $month, $filterAlreadySent),
        ]);
    }

    /**
     * @param $year
     * @param $month
     * @param $filterAlreadySent
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function filterPayments($year, $month, $filterAlreadySent)
    {
        // Create a date from the given year & month
        $date = Carbon::create($year, $month);

        $query = Payment::query()
            ->where('payment_at', '>=', $date->startOfMonth()->format('Y-m-d'))
            ->where('payment_at', '<=', $date->endOfMonth()->format('Y-m-d'));

        // Check if we should hide the payments that have been sent to splitwise
        if ($filterAlreadySent) {
            $query->whereNull('splitwise_id');
        }

        // Remove payments that are positive (received)
        $query->where('value', '<', 0);

        // If description is empty, it means it's cents added to the vault
        //        $query->whereNotNull('description');
        $query->where('description', '!=', '');

        return $query->get();
    }

    /**
     * @param ProcessRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function process(ProcessRequest $request)
    {
        // TODO, sent to splitwise
        $payments = $request->get('payments', []);
        //
        $me = 11349723;
        $friendId = 4050136; // Sima

        foreach ($payments as $paymentId => $payment) {

            var_dump($paymentId);
            var_dump($payment);

            $paymentModel = Payment::find($paymentId);
            var_dump($paymentModel->getAttributes());
            echo '<hr/>';

            try {
                $client = new GuzzleClient([
                    'base_uri' => config('splitwise.base_uri'),
                ]);

                $response = $client->post('create_expense', [
                    'json'    => [
                        //                        currency_code: "UYU",
                        //                        group_id: 987675,
                        //                        users: [
                        //                          %{id: 12345, paid_share: 100, owed_share: 0},
                        //                          %{id: 23456, paid_share: 0, owed_share: 100},
                        //                        ],
                        //                        category_id: 18,
                        'users'       => [
                            ['id' => $me, 'paid_share' => $payment['value'], 'owed_share' => 0],
                            ['id' => $friendId, 'paid_share' => 0, 'owed_share' => $payment['value']],
                        ],
                        'payment'     => true,
                        'description' => $payment['description'],
                        'cost'        => $payment['value'],
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                    ],
                ]);

                $response = $response->getBody()->getContents();

                var_dump($response);
                exit;

            } catch (\Exception $exception) {

                var_dump($exception);
                exit;


                \Log::channel('splitwise')->error('Could not create payment', ['exception' => $exception]);
            }
        }


        var_dump('eind');
        exit;
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
                'counterparty_alias',
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

