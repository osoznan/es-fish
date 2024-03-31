<?php

use App\Components\Translation as t;

/** @var $url */
/** @var $article */

?>

<div class="blog-thumb col-sm=12 col-lg-4 p-3 bordered-child-cells">
    <div>
        <a href="{{ $url }}">
            <div data-src="/img/photos/{{ $article->image->url }}" class="blog-thumb__image">

            </div>
        </a>
    </div>
    <div class="blog-thumb__date">
        {{ $article->created_at->toDateString() }}
    </div>
    <a href="{{ $url }}" class="blog-thumb__title">
        {{ t::getLocaleField($article, 'title') }}
    </a>
    <a href="{{ $url }}" class="blog-thumb__text">
        {{ html_entity_decode(Str::limit(strip_tags(t::getLocaleField($article, 'text'), 200))) }}
    </a>
</div>
