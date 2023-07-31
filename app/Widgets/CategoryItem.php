<?php

namespace App\Widgets;

use App\Components\Widget;

class CategoryItem extends Widget {

    use AjaxWidget;

    public $parentCategory;
    public $category;
    public $class;

    public static function getAjaxHandlers() {
        return ['getHello'];
    }

    public function run() {

        echo view('widgets.category_item', [
            'parentCategory' => $this->parentCategory,
            'category' => $this->category,
            'class' => $this->class
        ]);
    }

}
