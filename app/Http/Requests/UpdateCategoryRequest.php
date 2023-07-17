<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 */
class UpdateCategoryRequest extends CreateCategoryRequest
{

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => $name = 'required|min:3|max:100',
            'name_ua' => $name,
            'name_en' => $name,
        ]);

    }
}
