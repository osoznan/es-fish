<?php

namespace App\Http\Resources;

use App\Models\DeliveryType;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $deliveryType = DeliveryType::getValue($this->payment_type_id);
        $paymentType = DeliveryType::getValue($this->paymentType);

        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'name' => $this->name,
            'payment_type' => [
                'id' => $paymentType->id,
                'name' => $paymentType->name
            ],
            'delivery_type' => [
                'id' => $deliveryType->id,
                'name' => $deliveryType->name
            ],
            'status_id' => $this->status_id,
            'total' => $this->total,
            'seen' => $this->seen,
            'extra_data' => $this->extra_data,
            'products' => $this->items,
            'created_at' => $this->created_at
        ];
    }

}
