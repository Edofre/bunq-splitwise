<?php

namespace App\Http\Controllers\Splitwise;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class ExpenseController
 * @package App\Http\Controllers\Splitwise
 */
class ExpenseController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {
            $client = new GuzzleClient([
                'base_uri' => config('splitwise.base_uri'),
            ]);

            $response = $client->post('get_expenses', [
                'headers' => [
                    'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                ],
            ]);

            $response = $response->getBody()->getContents();

            return view('splitwise.expenses.index')->with([
                'expenses' => collect(json_decode($response)->expenses),
            ]);
        } catch (\Exception $exception) {
            \Log::channel('splitwise')->error('Could not list expenses', ['exception' => $exception]);
            abort(500, $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $client = new GuzzleClient([
                'base_uri' => config('splitwise.base_uri'),
            ]);

            $response = $client->post("get_expense/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                ],
            ]);
            $response = $response->getBody()->getContents();

            dd(json_decode($response)->expense);
            exit;

            return view('splitwise.expenses.show')->with([
                'expense' => json_decode($response)->expense,
            ]);

        } catch (\Exception $exception) {
            \Log::channel('splitwise')->error('Could not find expense', ['exception' => $exception]);
            abort(404, __('splitwise.expense_not_found'));
        }
    }
}
