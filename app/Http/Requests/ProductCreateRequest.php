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
            'category_id' => 'required|exists:product_category',
            'price' => 'integer|min:1',
            'seo' => $seoRule = 'string|min:3',
            'seo_en' => $seoRule,
            'seo_ua' => $seoRule,
            'calc_type' => 'integer',
            'menu_present' => 'bool',
            'rating' => 'integer|min:0|max:5'
        ];
    }

}
