<?php

namespace App\Widgets;

use App\Components\Widget;
use App\Models\Category;
use App\Models\Product;

class ProductItemList extends Widget {

    public function run() {
        /** @var $product Product */
        $productList = $this->productList; ?>

        <div class="row">
        <?php foreach ($productList as $product): ?>
            <div class="col col-md-6 col-lg-3">
                <?= ProductItem::widget([
                    'product' => $product,
                ]) ?>
            </div>
        <?php endforeach ?>
        </div> <?php
    }
}
