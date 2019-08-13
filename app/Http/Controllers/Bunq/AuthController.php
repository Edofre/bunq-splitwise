<?php

namespace App\Http\Controllers\Bunq;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Bunq
 */
class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        // Don't instantiate bunq api context, we're using oauth2 here
        // parent::__construct();

        // Make sure oauth configuration is set
        foreach ([
            config('bunq.oauth.url'),
            config('bunq.oauth.url_token'),
            config('bunq.oauth.redirect_uri'),
            config('bunq.oauth.client_id'),
            config('bunq.oauth.client_secret'),
        ] as $config) {
            if (is_null($config)) {
                abort(500, 'Please add all the bunq configuration entries in config/bunq.php');
            }
        }
    }

    /**
     *
     */
    public function oauth()
    {
        dd('not implemented currently');
        //        var_dump('w');

        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => config('bunq.oauth.client_id'),
            'redirect_uri'  => config('bunq.oauth.redirect_uri'),
            'state'         => $test,
        ]);

        //        var_dump($query);

        return redirect(config('bunq.oauth.url') . '?' . $query);

    }

    /**
     * @param Request $request
     */
    public function processRedirect(Request $request)
    {
        var_dump($request->get('code'));
        var_dump($request->get('amp;state'));
        exit;
    }

    /**
     *
     */
    public function token()
    {
        $client = new GuzzleClient([
            'base_uri' => config('bunq.oauth.url_token'),
        ]);

        $query = http_build_query([
            'grant_type'    => 'authorization_code',
            'code'          => env('BUNQ_TEST'), // Will be implemented in session later
            'redirect_uri'  => config('bunq.oauth.redirect_uri'),
            'client_id'     => config('bunq.oauth.client_id'),
            'client_secret' => config('bunq.oauth.client_secret'),
        ]);

        $response = $client->post('/v1/token' . '?' . $query);

        $response = collect($response->getBody()->getContents());
        var_dump($response);
        exit;
    }
}
