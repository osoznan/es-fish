<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int order_id
 * @property int status_id
 * @property string description
 */
class OrderStatusHistorySetStatusRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'status_id' => 'required|integer|min:1|exists:order_status,id',
        ];

    }
}
