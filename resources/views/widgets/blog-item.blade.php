<?php

use App\Components\Translation as t;

/** @var $url */
/** @var $article */

?>

<div class="blog-thumb col-6 col-lg-4 p-3 bordered-child-cells">
    <div>
        <a href="{{ $url }}?>">
            <div data-src="/img/photos/<?= $article->image->url ?>" class="blog-thumb__image">

            </div>
        </a>
    </div>
    <div class="blog-thumb__date">
        {{ $article->created_at }}
    </div>
    <a href="{{ $url }}" class="blog-thumb__title">
        <?= t::getLocaleField($article, 'title') ?>
    </a>
    <a href="{{ $url }}" class="blog-thumb__text">
        <?= Str::limit(t::getLocaleField($article, 'text'), 200) ?>
    </a>
</div>
