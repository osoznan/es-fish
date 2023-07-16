<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property int parent_category_id
 */
class CreateCategoryRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100|unique:product_category',
            'description' => 'required|min:10|max:10000',
            'parent_category_id' => 'nullable|integer',
        ];

    }
}
