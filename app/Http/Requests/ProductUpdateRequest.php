<?php

namespace App\Http\Requests;

class ProductUpdateRequest extends ProductCreateRequest {

    public function rules()
    {
        return array_merge(
            parent::rules(), [
                'name' => $nameRule = 'required|min:3|max:100',
                'name_ua' => $nameRule,
                'name_en' => $nameRule,
            ]);
    }
}
