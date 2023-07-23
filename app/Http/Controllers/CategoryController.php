<?php

namespace App\Http\Controllers;

use App\Components\CategoryManager;
use Illuminate\Support\Facades\Route;

class CategoryController extends TopController {

    public function category() {
        $categoryAlias = Route::current()->parameter('category');
        $subCategoryAlias = Route::current()->parameter('subcategory');

        $catInfo = CategoryManager::getCategoryInfo($categoryAlias, $subCategoryAlias);

        return view('category.index', [
            'category' => $catInfo[0],
            'subCategory' => $catInfo[1]
        ]);
    }

}
