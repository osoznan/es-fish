<?php

namespace App\Widgets;

use App\Components\Widget;
use App\Models\BlogArticle;
use App\Components\Translation as t;
use App\Components\BlogManager;
use Illuminate\Support\Str;

class BlogItem extends Widget {

    public function run() {
        /** @var $product BlogArticle */
        $article = $this->article;

        ob_start();
        ob_implicit_flush(false);

        $url = BlogManager::getUrl($article);

        ?>
        <div class="blog-thumb col-6 col-lg-4">
            <div>
                <a href="<?= $url ?>">
                    <div data-src="/img/photos/<?= $article->image_url ?>" class="blog-thumb__image">

                    </div>
                </a>
            </div>
            <div class="blog-thumb__date">
                <?= $article->created_at ?>
            </div>
            <a href="<?= $url ?>" class="blog-thumb__title">
                <?= t::getLocaleField($article, 'title') ?>
            </a>
            <a href="<?= $url ?>" class="blog-thumb__text">
                <?= Str::limit(t::getLocaleField($article, 'text'), 200) ?>
            </a>
        </div>
        <?php

        return ob_get_clean();
    }

}
