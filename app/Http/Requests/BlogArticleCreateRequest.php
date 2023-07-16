<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string title
 * @property int title_en
 * @property int title_ua
 * @property string text
 * @property int text_en
 * @property int text_ua
 * @property int image_id
 * @property int category_id
 */
class BlogArticleCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:50',
            'title_ua' => 'required|min:3|max:20',
            'title_en' => 'required|min:3|max:20',
            'text' => 'required|min:|max:50000',
            'text_ua' => 'required|min:3|max:50000',
            'text_en' => 'required|min:3|max:50000',
            'image_id' => 'required|min:1|exists:image',
            'category_id' => 'required|min:1|exists:product_category'
        ];

    }
}
