<?php

namespace App\Http\Requests\Bunq\Payments;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProcessRequest
 * @package App\Http\Requests\Bunq\Payments
 */
class ProcessRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'payments' => 'required',
        ];
    }
}
