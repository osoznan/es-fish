<?php

namespace App\Http\Resources;

use App\Models\Image;

class ProductCollection
{
    /**
     * Присоединяем одним запросом все картинки для статей блога
     */
    public static function collection($collection)
    {
        return $collection;
    }
}
