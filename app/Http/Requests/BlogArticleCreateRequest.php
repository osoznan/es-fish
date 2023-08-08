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
            'title' => $title = 'required|min:3|max:50|unique:blog_article',
            'title_ua' => $title,
            'title_en' => $title,
            'text' => $text = 'required|min:3|max:50000',
            'text_ua' => $text,
            'text_en' => $text,
            'image_id' => 'required|integer|min:1|exists:image,id',
            'category_id' => 'required|min:1'
        ];

    }
}
