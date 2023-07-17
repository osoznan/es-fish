<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string text
 * @property int rate
 * @property string answer
 * @property int product_id
 */
class FeedbackUpdateRequest extends FeedbackCreateRequest
{

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'answer' => 'min:30|max:2000',
        ]);

    }
}
