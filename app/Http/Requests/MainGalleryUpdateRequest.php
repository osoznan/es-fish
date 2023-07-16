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
class MainGalleryUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'nullable|min:3|max:50',
            'title_ua' => 'nullable|min:3|max:30',
            'title_en' => 'nullable|min:3|max:30',
            'text' => 'nullable|min:|max:1000',
            'text_ua' => 'nullable|min:3|max:1000',
            'text_en' => 'nullable|min:3|max:1000',
        ];

    }
}
