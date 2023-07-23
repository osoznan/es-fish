<?php

namespace App\Widgets;

use App\Components\Widget;
use App\Models\Category;
use App\Models\Product;
use App\Components\Translation as t;

class CategoryItemList extends Widget {

    public $categoryId;
    public $limit;

    public function run() {
        $topMostCategory = Category::searchTopMost()
            ->with('image')
            ->where('product_category.id', $this->categoryId)
            ->where('main_page_present', 1)
            ->first();

        $categoryList = Category::searchActive()
            ->with('image')
            ->where('parent_category_id', $this->categoryId)
            ->limit($this->limit)->get();
        ?>

        <h2 class="category-list__title"><?= t::getLocaleField($topMostCategory, 'name') ?></h2>
        <div class="row"><?php
            foreach ($categoryList as $category):
                CategoryItem::widget([
                    'category' => $category
                ]);
            endforeach ?>
        </div> <?php
    }
}
