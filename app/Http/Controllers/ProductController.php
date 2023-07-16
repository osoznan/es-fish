<?php

namespace App\Http\Controllers;

use App\Components\CategoryManager;
use App\Models\BlogArticle;
use App\Components\Translation as t;
use App\Models\Comment;
use App\Models\Product;
use App\Widgets\FeedbackPanel;
use App\Widgets\ProductAmountSelector;
use App\Widgets\StarRating;
use Illuminate\Http\Request;

class ProductController extends TopController {

    public function callAction($method, $parameters) {
        $this->registerAjaxHandler(ProductAmountSelector::class);
        $this->registerAjaxHandler(FeedbackPanel::class);
        $this->registerAjaxHandler(StarRating::class);

        return parent::callAction($method, $parameters);
    }

    public function product(...$a) {

        $categoryAlias = $a[1];
        $subCategoryAlias = $a[2];
        $productAlias = $a[3];

        $product = Product::searchActive()
            ->where([t::getLocaleFieldName('alias') => $productAlias])
            ->first();

        abort_if(!$product, 404, 'Данный продукт не существует');

        $catInfo = CategoryManager::getCategoryInfo($categoryAlias, $subCategoryAlias);

        $feedbacks = Comment::searchActive()
            ->where(['product_id' => $product->id])
            ->get();

        $blogArticles = BlogArticle::query()
            ->where('blog_article.category_id', 2)
            ->limit(3)
            ->get();

        $recommendedProducts = Product::searchActive()
            ->where(['recommended' => 1])
            ->limit(4)
            ->get();

        return view('product.index', [
            'category' => $catInfo[0],
            'subCategory' => $catInfo[1],
            'product' => $product,
            'feedbacks' => $feedbacks,
            'blogArticles' => $blogArticles,
            'recommendedProducts' => $recommendedProducts
        ]);
    }

    public function vote(Request $request) {
        dd($request->post());
    }

}
