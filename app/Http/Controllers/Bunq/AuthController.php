<?php

namespace App\Http\Controllers\Bunq;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AuthController
 * @package App\Http\Controllers\Bunq
 */
class AuthController extends Controller
{
    /** @var string */
    const BUNQ_RESPONSE_TYPE = 'code';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        // Don't instantiate bunq api context, we're using oauth2 here
        parent::__construct();

        // Make sure oauth configuration is set
        foreach ([
            config('bunq.oauth.authorize_uri'),
            config('bunq.oauth.token_uri'),
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function oauth()
    {
        // Create unique state to double check API
        $state = Str::random(32);
        session()->put('bunq_state', $state);

        $query = http_build_query([
            'response_type' => self::BUNQ_RESPONSE_TYPE,
            'client_id'     => config('bunq.oauth.client_id'),
            'redirect_uri'  => config('bunq.oauth.redirect_uri'),
            'state'         => $state,
        ]);

        return redirect(config('bunq.oauth.authorize_uri') . '?' . $query);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRedirect(Request $request)
    {
        $state = $request->get('amp;state');
        $code = $request->get('code');

        if ($state !== session()->get('bunq_state')) {
            flash(__('bunq.flash_state_does_not_match'))->error();
            return redirect()->to('home');
        }

        $client = new GuzzleClient([
            'base_uri' => config('bunq.oauth.token_uri'),
        ]);

        $query = http_build_query([
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => config('bunq.oauth.redirect_uri'),
            'client_id'     => config('bunq.oauth.client_id'),
            'client_secret' => config('bunq.oauth.client_secret'),
        ]);

        try {
            $response = $client->post('/v1/token' . '?' . $query);
            $response = json_decode($response->getBody()->getContents());

            // Make sure we have a proper response
            if ($response !== false) {
                // Update the encrypted token in the user
                $user = auth()->user();
                $user->update([
                    'bunq_token' => encrypt($response->access_token),
                ]);

                flash(__('bunq.flash_successfully_connected'))->success();
            } else {
                flash(__('bunq.flash_could_not_connect'))->error();
            }
        } catch (\Exception $exception) {
            // TODO, log error
            flash(__('bunq.flash_oauth_error', ['error' => $exception->getMessage()]))->error();
        }

        return redirect()->to('home');
    }

}
