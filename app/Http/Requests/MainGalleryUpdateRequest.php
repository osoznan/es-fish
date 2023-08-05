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
class MainGalleryUpdateRequest extends MainGalleryCreateRequest
{

}
