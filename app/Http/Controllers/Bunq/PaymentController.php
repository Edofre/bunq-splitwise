<?php

namespace App\Http\Controllers\Bunq;

use App\Http\Requests\Bunq\Payments\FilterRequest;
use App\Http\Requests\Bunq\Payments\ProcessRequest;
use App\Jobs\Splitwise\SendPayments;
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
     * Create a new controller instance.
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('bunq.payments.index')->with([]);
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

        // Query our payments to get the requested date
        $query = Payment::query()
            ->where('payment_at', '>=', $date->startOfMonth()->format('Y-m-d'))
            ->where('payment_at', '<=', $date->addMonth(1)->startOfMonth()->format('Y-m-d'));

        // Check if we should hide the payments that have been sent to splitwise
        if ($filterAlreadySent) {
            $query->whereNull('splitwise_id');
        }

        // Remove payments that are positive (received)
        $query->where('value', '<', 0);

        // If description is empty, it means it's cents added to the vault
        //        $query->whereNotNull('description');
        $query->where('description', '!=', '');

        $query->orderByDesc('payment_at');

        return $query->get();
    }

    /**
     * @param ProcessRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function process(ProcessRequest $request)
    {
        $payments = $request->get('payments', []);

        // Get current user
        $user = $this->getCurrentUser();

        if (!is_null($user)) {
            // Dispatch the job that will send the payments
            SendPayments::dispatch($user->id, auth()->user()->splitwise_token, $payments);
            flash(__('splitwise.payments_sent'))->success();
        } else {
            flash(__('splitwise.could_not_fetch_user'))->error();
        }
        return redirect()->route('bunq.payments.filter');
    }

    /**
     * @return object|null
     */
    private function getCurrentUser()
    {
        $client = new GuzzleClient([
            'base_uri' => config('splitwise.base_uri'),
        ]);

        $response = $client->post('get_current_user', [
            'headers' => [
                'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());

        // Return the user if it's set, otherwise null
        return $response->user ?? null;
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
