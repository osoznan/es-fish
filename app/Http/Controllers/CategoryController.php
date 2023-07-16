<?php

namespace App\Http\Controllers;

use App\Components\CategoryManager;
use App\Models\Category;
use App\Components\Translation as t;
use App\Models\Product;

class CategoryController extends TopController {

    public function category(...$a) {
        $categoryAlias = $a[1];
        $subCategoryAlias = $a[2] ?? null;

        $catInfo = CategoryManager::getCategoryInfo($categoryAlias, $subCategoryAlias);

        return view('category.index', [
            'category' => $catInfo[0] ?? null,
            'subCategory' => $catInfo[1]
        ]);
    }

}
