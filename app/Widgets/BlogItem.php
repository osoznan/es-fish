<?php

namespace App\Widgets;

use App\Components\Widget;
use App\Models\BlogArticle;
use App\Components\Translation as t;
use App\Components\BlogManager;
use Illuminate\Support\Str;

class BlogItem extends Widget {

    public BlogArticle $article;

    public function run() {
        $article = $this->article;

        echo view('widgets.blog-item', [
            'article' => $article,
            'url' => BlogManager::getUrl($article)
        ]);
    }

}
