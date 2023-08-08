<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderCollection
{

    public static function collection($collection)
    {
        $data = new Collection();

        foreach ($collection as $item) {
            $data->add((new OrderResource($item))->toArray(new Request()));
        }

        return $data;
    }
}
