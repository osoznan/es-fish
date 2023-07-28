<?php

use App\Components\Translation as t;
use App\Components\Translation;
use Illuminate\Support\Str;

/** @var $category \App\Models\Category */
/** @var $parentCategory \App\Models\Category */

?>

<div class="category-thumb <?= isset($class) ? $class : 'col-sm-12 col-md-6 col-lg-4 col-xl-3' ?> bordered-child-cells">
    <a href="<?= route('category', [
        'category' => $parentCategory->getLocaleAlias(),
        'subcategory' => $category->getLocaleAlias(),
        'locale' => Translation::getLocale()
    ])?>" class="category-thumb__title">
        <div data-src="/img/photos/<?= $category->image->url ?>" class="category-thumb__image mb-3">

        </div>

        <?= t::getLocaleField($category, 'name') ?>
    </a>
    <a href="" class="category-thumb__description">
        <?= Str::limit(t::getLocaleField($category, 'description'), 100) ?>
    </a>
</div>
