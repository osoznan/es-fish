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
class FeedbackUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'nullable|min:2|max:50',
            'text' => 'nullable|min:50|max:2000',
            'rate' => 'nullable|min:1|max:5',
            'answer' => 'nullable|min:50|max:2000',
            'product_id' => 'required|exists:product',
            'hidden' => 'boolean'
        ];

    }
}
