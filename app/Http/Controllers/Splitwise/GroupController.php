<?php

namespace App\Http\Controllers\Splitwise;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class GroupController
 * @package App\Http\Controllers\Splitwise
 */
class GroupController extends Controller
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

            $response = $client->post('get_groups', [
                'headers' => [
                    'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                ],
            ]);

            $response = $response->getBody()->getContents();

            return view('splitwise.groups.index')->with([
                'groups' => collect(json_decode($response)->groups),
            ]);
        } catch (\Exception $exception) {
            \Log::channel('splitwise')->error('Could not list groups', ['exception' => $exception]);
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

            $response = $client->post("get_group/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
                ],
            ]);
            $response = $response->getBody()->getContents();

            return view('splitwise.groups.show')->with([
                'group' => json_decode($response)->group,
            ]);

        } catch (\Exception $exception) {
            \Log::channel('splitwise')->error('Could not find group', ['exception' => $exception]);
            abort(404, __('splitwise.group_not_found'));
        }
    }
}
