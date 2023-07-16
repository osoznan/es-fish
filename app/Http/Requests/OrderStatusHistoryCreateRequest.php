<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int order_id
 * @property int status_id
 * @property string description
 */
class OrderStatusHistoryCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|min:1|exists:order',
            'status_id' => 'required|integer|min:1|exists:status',
            'description' => 'required|string|min: 5|max:1000'
        ];

    }
}
