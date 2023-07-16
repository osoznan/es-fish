<?php

use App\Components\Translation as t;
use App\Components\Translation;
use App\Components\Translit;
use App\Http\Controllers\TopController;
use Illuminate\Support\Str;

/** @var $category \App\Models\Category */
/** @var $parentCategory \App\Models\Category */

return

?>

<div class="category-thumb <?= isset($class) ? $class : 'col-6 col-lg-3' ?>">
    <a href="<?= route('category', [
        'category' => $parentCategory->getLocaleAlias(),
        'subcategory' => $category->getLocaleAlias(),
        'locale' => Translation::getLocale()
    ])?>" class="category-thumb__title">
        <div data-src="/img/photos/<?= $category->image_url ?>" class="category-thumb__image mb-3">

        </div>

        <?= t::getLocaleField($category, 'name') ?>
    </a>
    <a href="" class="category-thumb__description">
        <?= Str::limit(t::getLocaleField($category, 'description'), 100) ?>
    </a>
</div>
