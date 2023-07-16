<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        $result = array_merge(
            $this->toArray($request), [
                'category' => $this->category,
                'images' => $this->images
            ]
        );

    }

}
