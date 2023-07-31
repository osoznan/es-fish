<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return $this->getData($this);
    }

    protected function getData($category, $isWithParent = true) {
        return [
            'id' => $category->id,
            'name' => $category->local('title'),
            'description' => $category->local('text'),
            'alias' => $category->local('alias'),
            'image' => new ImageResource($category->image),
            'parent' => $isWithParent ? $this->getData($category->parent, false) : null,
            'main_page_present' => $this->main_page_present,
            'hidden' => $this->hidden,
            'created_at' => $category->created_at,

            'seo' => [
                'title' => $this->locale('seo_title'),
                'keywords' => $this->locale('seo_keywords'),
                'description' => $this->locale('seo_description'),
            ]
        ];
    }



}
