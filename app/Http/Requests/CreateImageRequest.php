<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string description
 * @property int parent_category_id
 */
class CreateImageRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:20|unique:image',
            'description' => 'required|min:10|max:10000',
            'parent_category_id' => 'nullable|integer|min:1|max:3',
        ];

    }
}
