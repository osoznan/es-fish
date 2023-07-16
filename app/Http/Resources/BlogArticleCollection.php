<?php

namespace App\Http\Resources;

use App\Models\Image;

class BlogArticleCollection
{
    /**
     * Присоединяем одним запросом все картинки для статей блога
     */
    public static function collection($collection)
    {
        $data = $collection;

        $images = Image::query()->whereIn(
            'id',
            $data->pluck('image_id')
        )->get()->keyBy('id');

        foreach ($data as &$article) {
            if ($image = $images->get($article->image_id)) {
                $article->image = [
                    'id' => $image->id,
                    'url' => $image->url
                ];
            } else {
                $article->image = [];
            }
        }

        return $data->toArray();
    }
}
