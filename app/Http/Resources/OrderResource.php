<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'name' => $this->name,
            'payment_type_id' => $this->payment_type_id,
            'delivery_type_id' => $this->delivery_type_id,
            'status_id' => $this->status_id,
            'total' => $this->total,
            'seen' => boolval($this->seen),
            'extra_data' => $this->extra_data,
            'products' => $this->items
        ];
    }

}
