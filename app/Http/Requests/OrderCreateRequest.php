<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string title
 * @property int title_en
 * @property int title_ua
 * @property string text
 * @property int text_en
 * @property int text_ua
 * @property int image_id
 * @property int category_id
 */
class OrderCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:50',
            'phone' => 'required|min:3|max:20',
            'payment_type_id' => 'required',
            'delivery_type_id' => 'required',
        ];

    }
}
