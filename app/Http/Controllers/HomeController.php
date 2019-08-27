<?php

namespace App\Http\Controllers;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        return redirect()->route('bunq.payments.filter');

        return view('home')->with([
            'bunqToken'      => $user->bunq_token,
            'splitwiseToken' => $user->splitwise_token,
        ]);
    }
}
