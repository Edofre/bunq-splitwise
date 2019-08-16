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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRedirect(Request $request)
    {
        $error = $request->get('error', false);
        $code = $request->get('code');

        if ($error !== false) {
            flash(__('splitwise.flash_oauth_error', ['error' => $error]))->error();
            return redirect()->to('home');
        }

        $client = new GuzzleClient();
        $query = http_build_query([
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => config('splitwise.oauth.redirect_uri'),
            'client_id'     => config('splitwise.oauth.client_id'),
            'client_secret' => config('splitwise.oauth.client_secret'),
        ]);

        try {
            $response = $client->post(config('splitwise.oauth.token_uri') . '?' . $query);
            $response = json_decode($response->getBody()->getContents());

            // Make sure we have a proper response
            if ($response !== false) {
                // Update the encrypted token in the user
                $user = auth()->user();
                $user->update([
                    'splitwise_token' => encrypt($response->access_token),
                ]);

                flash(__('splitwise.flash_successfully_connected'))->success();
            } else {
                flash(__('splitwise.flash_could_not_connect'))->error();
            }
        } catch (\Exception $exception) {
            // TODO, log error
            flash(__('splitwise.flash_oauth_error', ['error' => $exception->getMessage()]))->error();
        }

        return redirect()->to('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disconnect()
    {
        // Update the encrypted token in the user
        $user = auth()->user();
        $user->update([
            'splitwise_token' => null,
        ]);

        flash(__('splitwise.flash_successfully_disconnected'))->success();
        return redirect()->to('home');
    }
}
