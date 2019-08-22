<?php

namespace App\Http\Controllers\Bunq;

use bunq\Model\Generated\Endpoint\MonetaryAccount;

/**
 * Class MonetaryAccountController
 * @package App\Http\Controllers\Bunq
 */
class MonetaryAccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $monetaryAccountList = collect(MonetaryAccount::listing()->getValue());

        //        // Debug
        //        foreach ($monetaryAccountList as $monetaryAccount) {
        //            var_dump($monetaryAccount);
        //            var_dump($monetaryAccount->getReferencedObject()->getId());
        //            var_dump($monetaryAccount->getReferencedObject()->getDescription());
        //            var_dump($monetaryAccount->getReferencedObject()->getBalance()->getValue());
        //            echo '<hr/><hr/>';
        //        }
        //        exit;

        return view('bunq.monetary-accounts.list')->with([
            'monetaryAccounts' => $monetaryAccountList,
        ]);
    }

    /**
     * @param $monetaryAccountId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($monetaryAccountId)
    {
        $monetaryAccount = MonetaryAccount::get($monetaryAccountId)->getValue();

        return view('bunq.monetary-accounts.show')->with([
            'monetaryAccountId' => $monetaryAccountId,
            'monetaryAccount'   => $monetaryAccount,
        ]);
    }

}
