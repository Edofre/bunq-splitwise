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
    public function index()
    {
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

            return view('splitwise.friends.index')->with([
                'friends' => collect(json_decode($response)->friends),
            ]);
        } catch (\Exception $exception) {
            \Log::channel('splitwise')->error('Could not list friends', ['exception' => $exception]);
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

            $response = $client->post("get_friend/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                ],
            ]);
            $response = $response->getBody()->getContents();

            return view('splitwise.friends.show')->with([
                'friend' => json_decode($response)->friend,
            ]);

        } catch (\Exception $exception) {
            \Log::channel('splitwise')->error('Could not find friend', ['exception' => $exception]);
            abort(404, __('splitwise.friend_not_found'));
        }
    }
}
