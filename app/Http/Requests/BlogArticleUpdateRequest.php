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
class BlogArticleUpdateRequest extends BlogArticleCreateRequest
{

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'title' => $title = 'required|min:3|max:50',
            'title_ua' => $title,
            'title_en' => $title,
        ]);

    }
}
