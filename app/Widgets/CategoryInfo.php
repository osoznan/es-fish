<?php

namespace App\Widgets;

use App\Components\Widget;
use App\Models\Category;

class CategoryInfo extends Widget {

    use AjaxWidget;

    public Category $category;

    public static function getAjaxHandlers() {
        return ['getHello'];
    }

    public function run() {
        echo view('widgets.category-info', [
            'category' => $this->category,
        ]);
    }

}
