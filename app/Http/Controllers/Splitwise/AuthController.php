<?php

namespace App\Http\Controllers\Splitwise;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Splitwise
 */
class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Make sure oauth configuration is set
        foreach ([
            config('splitwise.oauth.authorize_uri'),
            config('splitwise.oauth.token_uri'),
            config('splitwise.oauth.redirect_uri'),
            config('splitwise.oauth.client_id'),
            config('splitwise.oauth.client_secret'),
        ] as $config) {
            if (is_null($config)) {
                abort(500, 'Please add all the splitwise configuration entries in config/splitwise.php');
            }
        }
    }

    /**
     *
     */
    public function oauth()
    {
        $params = [
            'response_type' => 'code',
            'client_id'     => config('splitwise.oauth.client_id'),
            'redirect_uri'  => config('splitwise.oauth.redirect_uri'),
        ];
        $query = http_build_query($params);

        return redirect(config('splitwise.oauth.authorize_uri') . '?' . $query);
    }

    /**
     * @param Request $request
     */
    public function processRedirect(Request $request)
    {
        var_dump($request->get('code'));
        var_dump($request->get('state'));
        exit;
    }

    /**
     *
     */
    public function token()
    {
        $client = new GuzzleClient();

        $query = http_build_query([
            'grant_type'    => 'authorization_code',
            'code'          => env('SPLITWISE_CODE'), // Will be fixed later
            'redirect_uri'  => config('splitwise.oauth.redirect_uri'),
            'client_id'     => config('splitwise.oauth.client_id'),
            'client_secret' => config('splitwise.oauth.client_secret'),
        ]);

        $response = $client->post(config('splitwise.oauth.token_uri') . '?' . $query);

        $response = collect($response->getBody()->getContents());
        var_dump($response);
        exit;
    }
}
