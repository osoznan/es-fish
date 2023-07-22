<?php

namespace App\Widgets;

use App\Components\ImageManager;
use App\Components\Widget;
use App\Models\ProductImage;
use Illuminate\Support\Collection;

class ProductCarousel extends Widget {

    public object $product;

    public function run() {
        $product = $this->product;

        $mainImage = ['id' => 0, 'product_id' => $product->id, 'image_id' => $product->image_id, 'image' => $product->image];

        $productImages = ProductImage::where('product_id', $product->id)->with('image')->get()->toArray();
        $productImages = array_merge([$mainImage], $productImages);

        echo view('widgets.product-carousel', [
            'images' => $productImages
        ]);
    }
}
