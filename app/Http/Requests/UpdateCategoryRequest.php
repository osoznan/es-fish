<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 */
class UpdateCategoryRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'min:3|max:100|unique:product_category',
            'description' => 'nullable|string|min:10|max:10000',
        ];

    }
}
