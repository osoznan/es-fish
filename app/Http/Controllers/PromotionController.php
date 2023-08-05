<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PromotionController extends TopController {

    public function index() {
        return view('promotions',[
            'promotions' => Product::searchActive()
                ->where('promotion_price', '>', 0)->get()
        ]);
    }

}
