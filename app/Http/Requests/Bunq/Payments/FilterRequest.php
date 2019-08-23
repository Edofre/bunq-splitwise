<?php

namespace App\Http\Requests\Bunq\Payments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class FilterRequest
 * @package App\Http\Requests\Bunq\Payments
 */
class FilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'month' => [
                'nullable',
                Rule::in(range(1, 12)),
            ],
            'year'  => [
                'nullable',
                Rule::in(range(2012, 2100)),
            ],
        ];
    }
}
