<?php

use App\Components\Translation as t;
use Illuminate\Support\Str;
use App\Components\CategoryManager;

/** @var $category \App\Models\Category */
/** @var $parentCategory \App\Models\Category */

?>

<div class="category-thumb {{ isset($class) ? $class : 'col-sm-12 col-md-6 col-lg-4 col-xl-3' }} bordered-child-cells">
    <a href="{{ CategoryManager::getUrl($category) }}" class="category-thumb__title">
        <div data-src="/img/photos/{{ $category->image->url }}" class="category-thumb__image mb-3"></div>

        {{ t::getLocaleField($category, 'name') }}
    </a>
    <a href="" class="category-thumb__description">
        {!! Str::limit(strip_tags(t::getLocaleField($category, 'description')), 120) !!}
    </a>
</div>
