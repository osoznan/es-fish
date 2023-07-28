<?php

namespace App\Widgets;

use App\Components\Widget;
use App\Models\Category;
use App\Models\Product;

class ProductItemList extends Widget {

    public $productList;
    public $class;

    public function run() {
        /** @var $product Product */ ?>

        <div class="product-item-list row">
        <?php foreach ($this->productList as $product): ?>
            <?= ProductItem::widget([
                'product' => $product,
                'class' => $this->class
            ]) ?>
        <?php endforeach ?>
        </div> <?php
    }
}
