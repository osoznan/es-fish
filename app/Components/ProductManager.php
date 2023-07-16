<?php

namespace App\Components;

use Illuminate\Support\Facades\DB;

class ProductManager {

    public static function getUrl($product) {
        return CategoryManager::getUrl($product->category_id) . '/' . $product->getLocaleAlias();
    }

    public static function calculateRate($productId) {
        $comments = DB::table('comment')
            ->selectRaw("sum(rate) as `rate`, count(*) as `count`")
            ->whereRaw("product_id = $productId and hidden = 0")
            ->first();

        return $comments->count > 0 ? $comments->rate / $comments->count : 0;
    }

}
