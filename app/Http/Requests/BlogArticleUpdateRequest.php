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
 */
class BlogArticleUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'nullable|min:3|max:50',
            'title_ua' => 'nullable|min:3|max:20',
            'title_en' => 'nullable|min:3|max:20',
            'text' => 'nullable|min:|max:50000',
            'text_ua' => 'nullable|min:3|max:50000',
            'text_en' => 'nullable|min:3|max:50000',
            'image_id' => 'integer|min:1|exists:image',
            'category_id' => 'integer|min:1|exists:product_category'
        ];

    }
}
