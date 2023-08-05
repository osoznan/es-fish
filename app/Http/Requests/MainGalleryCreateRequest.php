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
class MainGalleryCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:50',
            'title_ua' => 'required|string|min:3|max:30',
            'image_id' => 'exists:image,id|required',
            'title_en' => 'required|string|min:3|max:30',
            'text' => 'required|string|min:3|max:300',
            'text_ua' => 'required|string|min:3|max:300',
            'text_en' => 'required|string|min:3|max:300',
        ];

    }
}
