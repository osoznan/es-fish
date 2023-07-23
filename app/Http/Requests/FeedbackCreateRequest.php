<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Components\Translation as t;

/**
 * @property string name
 * @property string text
 * @property int rate
 * @property string answer
 * @property int product_id
 */
class FeedbackCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:50',
            'text' => 'required|min:50|max:2000',
            'rate' => 'required|min:1|max:5',
            'answer' => 'nullable|min:30',
            'product_id' => 'required|exists:product,id',
            'hidden' => 'boolean'
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => t::inPlace('Имя должно быть введено|Имя повинно бути введеним|Name must be specified'),
            'text.required' => t::inPlace('Текст отзыва должен быть введён|Треба ввести текст отзиву|Feedback text must be specified'),
            'name.min' => t::inPlace('Слишком короткое имя|Занадто коротке iм\'я|Too short name'),
            'text.min' => t::inPlace('Слишком короткий текст|Занадто короткий текст|Too short text'),
            'answer' => 'nullable|min:30',
            'product_id' => 'required|exists:product,id',
            'hidden' => 'boolean'
        ];

    }
}
