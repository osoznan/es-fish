<?php

namespace App\Widgets;

use App\Components\ImageManager;
use App\Components\Widget;
use App\Models\ProductImage;

class ProductCarousel extends Widget {

    public function run() {
        $product = $this->product;

        $productImages = ProductImage::search()
            ->where('product_id', $product->id)
            ->get();

       // dd($productImages[0]);
        ?>
        <div id="product_carousel" class="product-carousel carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                $i = -1;
                foreach ($productImages as $image):
                    $i++;
                ?>
                    <div data-src="<?= ImageManager::getThumbsUrl($image->image_url) ?>" type="button" data-bs-target="#product_carousel" data-bs-slide-to="<?= $i ?>" class="<?= !$i ? 'active' : '' ?>" aria-current="<?= $i ? 'true' : 'false' ?>" aria-label="Slide 1"></div>
                <?php endforeach ?>
            </div>
            <div class="carousel-inner">
                <?php
                $i = 0;
                foreach ($productImages as $image):
                    $i++;
                ?>
                    <div class="carousel-item <?= $i == 1 ? 'active' : '' ?>">
                        <div class="product-carousel__image sect-product__image" data-src="<?= ImageManager::getPhotosUrl($image->image_url) ?>"></div>
                    </div>
                <?php endforeach ?>
            </div>
<!--            <button class="carousel-control-prev" type="button" data-bs-target="#product_carousel" data-bs-slide="prev">-->
<!--                <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--                <span class="visually-hidden">Previous</span>-->
<!--            </button>-->
<!--            <button class="carousel-control-next" type="button" data-bs-target="#product_carousel" data-bs-slide="next">-->
<!--                <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--                <span class="visually-hidden">Next</span>-->
<!--            </button>-->
        </div><?php
    }
}
