<?php

namespace App\Http\Controllers;

use App\Components\BlogManager;
use App\Components\CategoryManager;
use App\Models\BlogArticle;
use App\Models\Category;
use App\Components\Translation as t;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BlogController extends TopController {

    public function category(Request $request) {
        $categoryAlias = Route::current()->parameter('cat');

        $PER_PAGE = 4;

        $categoryId = BlogManager::getCategoryIdByAlias($categoryAlias);

        abort_if(!$categoryId, 404);

        $articles = BlogArticle::search()
            ->where('blog_article.category_id', $categoryId)
            ->forPage($request->page, $PER_PAGE)->get();

        $totalCount = BlogArticle::search()
            ->where('blog_article.category_id', $categoryId = BlogManager::getCategoryIdByAlias($categoryAlias))->count();

        return view('blog.category', [
            'categoryId' => $categoryId,
            'articles' => $articles,
            'pager' => [
                'curPage' => $request->page,
                'totalCount' => $totalCount,
                'perPage' => $PER_PAGE
            ]
        ]);
    }

    public function article() {
        $categoryAlias = Route::current()->parameter('cat');
        $articleAlias = Route::current()->parameter('article');

        if (!in_array($categoryAlias, BlogManager::CATEGORY_ALIASES['en'])) {
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
