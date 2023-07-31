<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->local('name'),

            'category' => $this->category,
            'image' => new ImageResource($this->image),
            'images' => $this->images,

            'price' => $this->price,
            'old_price' => $this->old_price,
            'weight' => $this->weight,
            'description' => $this->locale('description'),
            'properties' => $this->locale('properties'),
            'alias' => $this->locale('alias'),

            'present' => $this->present,
            'calc_type' => $this->calc_type,
            'menu_present' => $this->menu_present,
            'rating' => $this->rating,
            'recommended' => $this->recommended,
            'hidden' => $this->hidden,

            'seo' => [
                'title' => $this->locale('seo_title'),
                'keywords' => $this->locale('seo_keywords'),
                'description' => $this->locale('seo_description'),
            ]

        ];

    }

}
