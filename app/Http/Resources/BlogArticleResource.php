<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'title' => $this->title,
            'title_en' => $this->title_en,
            'title_ua' => $this->title_ua,
            'text' => $this->text,
            'text_en' => $this->text_en,
            'text_ua' => $this->text_ua,
            'alias' => $this->title,
            'alias_en' => $this->alias_en,
            'alias_ua' => $this->alias_ua,
            'created_at' => $this->created_at,
            'image' => new ImageResource($this->image)
        ]);
    }

}
