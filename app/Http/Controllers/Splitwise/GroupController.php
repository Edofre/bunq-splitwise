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
     *
     */
    public function list()
    {
        $client = new GuzzleClient([
            'base_uri' => config('splitwise.base_uri'),
        ]);

        $response = $client->post('get_groups', [
            'headers' => [
                'Authorization' => 'Bearer ' . decrypt(auth()->user()->splitwise_token),
            ],
        ]);

        $response = $response->getBody()->getContents();
        var_dump(json_decode($response));
        exit;
    }
}
