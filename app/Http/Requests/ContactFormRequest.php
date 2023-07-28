<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string phone
 * @property string message
 * @property string description
 */
class ContactFormRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:30',
            'phone' => 'required|min:10|max:16',
            'message' => 'required|min:10|max:3000',
            'description' => 'required'
        ];

    }

    public function attributes()
    {
        return [
            'name' => __('site.param.name'),
            'phone' => __('site.param.phone'),
            'message' => __('site.param.message'),
            'description' => __('site.contact-form.control-number')
        ];
    }
}
