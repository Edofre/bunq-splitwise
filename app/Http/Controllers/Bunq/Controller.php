<?php

namespace App\Http\Controllers\Bunq;

use App\Http\Controllers\Controller as BaseController;
use App\Models\User;
use bunq\Context\ApiContext;
use bunq\Context\BunqContext;
use bunq\Util\BunqEnumApiEnvironmentType;

/**
 * Class Controller
 * @package App\Http\Controllers\Bunq
 */
class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
        // We can't get the user from the auth in a regular way
        $this->middleware(function ($request, $next) {
            $user = \Auth::user();

            // Get the api context for this user & make sure the file exists
            $configFile = storage_path("bunq/{$user->id}.conf");
            if (!file_exists($configFile)) {
                $this->createApiContext($user, $configFile);
            }

            try {
                // Load bunq api context
                $apiContext = ApiContext::restore($configFile);
                BunqContext::loadApiContext($apiContext);
            } catch (\Exception $exception) {
                \Log::channel('bunq')->error('Could not restore api context', ['exception' => $exception]);

                // Remove the old bunq token
                $user->update([
                    'bunq_token' => null,
                ]);

                // Remove the context file if it exists
                if (file_exists($configFile)) {
                    \File::delete($configFile);
                }

                flash(__('bunq.flash_api_context_exception_disconnected'))->success();
                return redirect()->to('home');
            }

            return $next($request);
        });
    }

    /**
     * @param User $user
     * @param      $configFile
     * @throws \bunq\Exception\BunqException
     */
    private function createApiContext(User $user, $configFile)
    {
        $environmentType = BunqEnumApiEnvironmentType::PRODUCTION();
        $deviceDescription = 'bunq-splitwise app';
        $permittedIps = [];

        // Create the api context
        $apiContext = ApiContext::create(
            $environmentType,
            decrypt($user->bunq_token),
            $deviceDescription,
            $permittedIps
        );

        // Save the .conf file to storage
        $apiContext->save($configFile);
    }

}
