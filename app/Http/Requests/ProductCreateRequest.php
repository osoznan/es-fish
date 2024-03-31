<?php

namespace App\Http\Requests;

class ProductCreateRequest extends \Illuminate\Foundation\Http\FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => $nameRule = 'required|min:3|max:100|unique:product',
            'name_ua' => $nameRule,
            'name_en' => $nameRule,
            'description' => $descriptionRule = 'required|min:10|max:10000',
            'description_ua' => $descriptionRule,
            'description_en' => $descriptionRule,
            'category_id' => 'required|exists:product_category,id',
            'price' => 'integer|min:1',
            'old_price' => 'nullable|integer|min:1',
            'weight' => 'nullable|integer|min:1',
            'calc_type' => 'integer',
            'menu_present' => 'bool',
            'seo_title' => $seo = 'nullable|string|min:5',
            'seo_keywords' => $seo,
            'seo_description' => $seo,
            'seo_title_en' => $seo,
            'seo_keywords_en' => $seo,
            'seo_description_en' => $seo,
            'seo_title_ua' => $seo,
            'seo_keywords_ua' => $seo,
            'seo_description_ua' => $seo,
            'promotion_price' => 'nullable|integer|min:1',
            'promotion_start_date' => 'date|nullable',
            'promotion_finish_date' => 'date|nullable',
        ];
    }

}
