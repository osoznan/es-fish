<?php

use App\Models\Category;
use App\Models\Product;
use App\Components\ImageManager;
use App\Components\Translation as t;
use App\Components\CategoryManager;
use App\Components\ProductManager;
use App\Components\BlogManager;

$categories = Category::searchActive()->with('image')->with('parent')->get();

$topCategories = $categories->where('parent_category_id', null);

$subCategoriesSet = [];
foreach ($topCategories as $top) {
    $subCategoriesSet[$top['id']] = $categories->where('parent_category_id', $top['id']);
}

$menuProducts = Product::searchActive()
    ->with('category')
    ->where('menu_present', 1)->get();

?>
<section class="leftmenu container-fluid">
<div class="container">
    <div class="row">
        <div class="col-3 d-lg-block">
            <nav class="navbar navbar-light d-none d-lg-block">
                <div class="container">
                    <button class="navbar-toggler" onclick="landing.showMainMenu()">
                    <span class="navbar-toggler-icon"></span></button>
                </div>
            </nav>

            <a class="main-menu__close" onclick="landing.hideMainMenu()">&#215;</a>

            <ul class="main-menu__navbar navbar-nav mr-auto" id="leftMenu">
                <div class="main-menu__top-space">
                    <div class="main-menu__langs">
                        <?php foreach (['ua', 'ru', 'en'] as $lang):
                            if ($lang != t::getLocale()):
                                echo '<span><a href="/' . $lang . '" class="dark-text-anchor">' . strtoupper($lang) . '</a></span> ';
                            else:
                                echo '<span class="orange-color">' . strtoupper($lang) . '</span> ';
                            endif;
                        endforeach; ?>
                    </div>
                    <div class="flex-grow-1"></div>
                </div>

                <a href="{{ fishLink('/delivery-payment') }}" class="main-menu__item fw-bold">@lang('site.menu.delivery+pay')</a>
                <a href="{{ fishLink('/about') }}" class="navigation-link main-menu__item fw-bold">@lang('site.menu.about')</a>

                <div class="fw-bold main-menu__item">@lang('site.blog.materials')</div>
                <ul class="">
                    <a href="{{ BlogManager::getCategoryUrl(1) }}" class="navigation-link main-menu__item">@lang('site.blog.' . BlogManager::getCategoryAlias(1))</a>
                    <a href="{{ BlogManager::getCategoryUrl(2) }}" class="navigation-link main-menu__item">@lang('site.blog.' . BlogManager::getCategoryAlias(2))</a>
                    <a href="{{ BlogManager::getCategoryUrl(3) }}" class="navigation-link main-menu__item">@lang('site.blog.' . BlogManager::getCategoryAlias(3))</a>
                </ul>

                <a href="{{ fishLink('/contacts') }}" class="navigation-link main-menu__item fw-bold">@lang('site.menu.contacts')</a>

                <div class="d-block d-lg-none text-center">
                    <a href="{{ config('user.facebook') }}"><img src="/img/facebook.svg"></a>&nbsp;
                    <a href="{{ config('user.linkedin') }}"><img src="/img/linkedin.svg"></a>

                    @include('_templates/widgets/phone')
                    <span class="light-gray-color">@lang('site.index.cap.call-time')</span>
                </div>
            </ul>
        </div>
        <div class="col">
            <nav class="mainmenu__categories navbar navbar-expand-md overflow-hidden">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse d-flex">
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0 flex-row justify-content-center w-100">
                            @foreach ($topCategories as $category)
                            <li class="mainmenu__categories__item nav-item text-center">
                                <a class="mainmenu__categories__anchor nav-link active" href="#toggle{{ $category['id'] }}"
                                        data-bs-toggle="collapse" aria-controls="#toggle{{ $category['id'] }}"
                                        data-bs-target="#toggle{{ $category['id'] }}" data-bs-toggle="dropdown" role="button">
                                    <img class="mainmenu__categories__image" src="{{ config('user.top-category-pictures')[$category['id']] ?? '' }}">
                                    <div class="mainmenu__categories__title">{{ t::getLocaleField($category, 'name') }}</div>
                                </a>
                            </li>
                            @endforeach

                            <li class="mainmenu__categories__item nav-item text-center">
                                <a class="mainmenu__categories__anchor nav-link active" href="{{ fishLink('/promotions') }}">
                                    <img class="mainmenu__categories__image" src="/img/promotions.svg">
                                    <div class="mainmenu__categories__title">@lang('site.promotions.title')</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
</section>

<div class="mainmenu__subcategories bg-dark">
    <div class="container">
        @foreach ($topCategories as $top)
        <?php $subCategories = $subCategoriesSet[$top['id']] ?>

        <div id="toggle{{ $top['id'] }}" class="mainmenu__subcategories__toggle row collapse justify-content-around ignore-on-doc-click">

            {{ !count($subCategories) ? trans('site.category.no-subcategory-products') : '' }}

            @foreach ($subCategories as $category)
            <div class="col-12 col-lg-6 col-xl-4 d-flex flex-grow-1">
                <a href="{{ CategoryManager::getUrl($category) }}" style="display: contents">
                    <div class="mainmenu__subcategories__image m-2 div-image-thumb" data-src="{{ ImageManager::getPhotosUrl($category->image->url) }}"></div>
                </a>
                <div class="mainmenu__subcategories__text">
                    <div class="mainmenu__subcategories__title">
                        <a href="{{ CategoryManager::getUrl($category) }}" class="dark-text-anchor">{{ t::getLocaleField($category, 'name') }}</a>
                    </div>
                    <div class="mainmenu__subcategories__product-list">
                        @foreach ($menuProducts as $menuProduct)
                            @if ($menuProduct['category_id'] == $category['id'])
                                <a href="{{ ProductManager::getUrl($menuProduct) }}" class="dark-text-anchor">{{ $menuProduct->locale('name') }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>

