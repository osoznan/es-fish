<?php

namespace App\Http\Controllers;

use App\Components\BlogManager;
use App\Components\CategoryManager;
use App\Models\BlogArticle;
use App\Models\Category;
use App\Components\Translation as t;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

class BlogController extends TopController {

    public function category() {
        $categoryAlias = Route::current()->parameter('cat');

        $PER_PAGE = 4;

        $curPage = isset($_GET['page']) ? $_GET['page'] - 1 : 0;

        $categoryId = BlogManager::getCategoryIdByAlias($categoryAlias);

        abort_if(!$categoryId, 404);

        $articles = BlogArticle::search()
            ->where('blog_article.category_id', $categoryId)
            ->offset($PER_PAGE * $curPage)
            ->take($PER_PAGE)
            ->get();

        $totalCount = BlogArticle::search()
            ->where('blog_article.category_id', $categoryId = BlogManager::getCategoryIdByAlias($categoryAlias))->count();

        return view('blog.category', [
            'categoryId' => $categoryId,
            'articles' => $articles,
            'pager' => [
                'curPage' => $curPage,
                'totalCount' => $totalCount,
                'perPage' => $PER_PAGE
            ]
        ]);
    }

    public function article() {
        $categoryAlias = Route::current()->parameter('cat');
        $articleAlias = Route::current()->parameter('article');

        if (!in_array($categoryAlias, BlogManager::CATEGORY_ALIASES[t::getLocale()])) {
            throw new \Exception('wrong blog category:' . $categoryAlias);
        }

        $article = BlogArticle::searchActive()
            ->where([t::getLocaleFieldName('alias') => $articleAlias])
            ->first();

        return view('blog.article', [
            'article' => $article,
        ]);
    }

}
