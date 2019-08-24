<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Payment
 * @package App\Models
 * @property integer                    $bunq_payment_id
 * @property integer                    $bunq_monetary_account_id
 * @property integer|null               $splitwise_id
 * @property integer                    $value
 * @property string                     $currency
 * @property string                     $counterparty_alias
 * @property string                     $description
 * @property string                     $type
 * @property string                     $sub_type
 * @property \Illuminate\Support\Carbon $payment_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Virtual attributes
 * @property string                     $guessedDescription
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

        'counterparty_alias',
        'description',
        'type',
        'sub_type',

        'payment_at',
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

    /**
     * @return string
     */
    public function getGuessedDescriptionAttribute()
    {
        $description = $this->description;

        // We always show albert with the date
        if (Str::startsWith($description, 'ALBERT')) {
            return 'Albert ' . $this->payment_at->format('d-m');
        }


        return $description . ' ' . $this->payment_at->format('d-m');
    }
}
