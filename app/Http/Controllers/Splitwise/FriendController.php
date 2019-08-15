<?php

namespace App\Http\Controllers\Splitwise;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class FriendController
 * @package App\Http\Controllers\Splitwise
 */
class FriendController extends Controller
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
    public function list()
    {
        $friends = collect();

        try {
            $client = new GuzzleClient([
                'base_uri' => config('splitwise.base_uri'),
            ]);

            $response = $client->post('get_friends', [
                'headers' => [
                    'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                ],
            ]);

            $response = $response->getBody()->getContents();
            $friends = collect(json_decode($response)->friends);

        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }

        return view('splitwise.friends.list')->with([
            'friends' => $friends,
        ]);
    }
}
