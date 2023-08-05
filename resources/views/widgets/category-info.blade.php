<?php

use App\Models\Category;
use App\Components\CategoryManager;

/** @var Category $category */

?>

<section class="sect-seo">
    <div class="container">
        <div class="row">
            <div class="sect-seo__text col-12 col-lg-12">
<!--                <div class="sect-seo__small-header text-lg-left"></div>-->
                <h3 class="sect-seo__header text-lg-left">{{ $category->locale('name') }}</h3>
                <img class="category-seo__image" data-src="{{ $category->image->fullUrl }}">
                {!! $category->locale('description') !!}
<!--                <a href="{{ CategoryManager::getUrl($category)  }}" class="sect-seo__detailed mt-3">@lang('site.index.cap.detailed')</a>-->
            </div>
        </div>
    </div>
</section>
