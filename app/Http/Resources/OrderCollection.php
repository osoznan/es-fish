<?php

namespace App\Http\Resources;

use App\Models\Image;

class OrderCollection
{
    /**
     * Присоединяем одним запросом все картинки для статей блога
     */
    public static function collection($collection)
    {
        return $collection;
    }
}
