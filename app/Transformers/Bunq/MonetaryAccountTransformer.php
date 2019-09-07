<?php

namespace App\Transformers\Bunq;

use bunq\Model\Generated\Endpoint\MonetaryAccount;
use League\Fractal\TransformerAbstract;

/**
 * Class MonetaryAccountTransformer
 * @package App\Transformers\Bunq
 */
class MonetaryAccountTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     * @param MonetaryAccount $monetaryAccount
     * @return array
     * @throws \bunq\exception\BunqException
     */
    public function transform(MonetaryAccount $monetaryAccount)
    {
        return [
            'id'          => $monetaryAccount->getReferencedObject()->getId(),
            'description' => $monetaryAccount->getReferencedObject()->getDescription(),
            'balance'     => $monetaryAccount->getReferencedObject()->getBalance()->getValue(),
        ];
    }
}
