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
            'name' => $name = 'required|min:3|max:100|unique:product_category',
            'name_en' => $name,
            'name_ua' => $name,
            'description' => $description = 'required|min:10|max:10000',
            'description_en' => $description,
            'description_ua' => $description,
            'parent_category_id' => 'nullable|integer',
            'image' => 'required',
            'seo_title' => $seo = 'nullable|string|min:5',
            'seo_keywords' => $seo,
            'seo_description' => $seo,
            'seo_title_en' => $seo,
            'seo_keywords_en' => $seo,
            'seo_description_en' => $seo,
            'seo_title_ua' => $seo,
            'seo_keywords_ua' => $seo,
            'seo_description_ua' => $seo,
        ];

    }
}
