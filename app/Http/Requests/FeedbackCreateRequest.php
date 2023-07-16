<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string text
 * @property int rate
 * @property string answer
 * @property int product_id
 */
class FeedbackCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:50',
            'text' => 'required|min:50|max:2000',
            'rate' => 'required|min:1|max:5',
            'answer' => 'min:50',
            'product_id' => 'required',
            'hidden' => 'boolean'
        ];

    }
}
