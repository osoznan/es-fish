<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string datetime
 */
class GetModelListRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'page' => 'integer|min:1|nullable',
            'per_page' => 'integer|min:1|nullable'
        ];

    }
}
