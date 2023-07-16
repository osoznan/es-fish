<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property int parent_category_id
 */
class UpdateImageRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'nullable|min:3|max:20|unique:image',
            'description' => 'nullable|min:10|max:10000',
            'parent_category_id' => 'nullable|integer|min:1|max:3',
        ];

    }
}
