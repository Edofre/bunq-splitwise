<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 * @property integer                    $bunq_payment_id
 * @property integer                    $bunq_monetary_account_id
 * @property integer|null               $splitwise_id
 * @property integer                    $value
 * @property string                     $currency
 * @property string                     $description
 * @property string                     $type
 * @property string                     $sub_type
 * @property \Illuminate\Support\Carbon $payment_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Payment extends Model
{

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'bunq_payment_id',
        'bunq_monetary_account_id',
        'splitwise_id',

        'value',
        'currency',

        'description',
        'type',
        'sub_type',

        'payment_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'bunq_payment_id',
        'bunq_monetary_account_id',
        'splitwise_id',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'payment_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
