<?php

use App\Models\Category;
use App\Widgets\CategoryInfo;
use App\Components\Translation as t;
use App\Components\CategoryManager;
use App\Models\Product;
use App\Widgets\ProductItemList;
use App\Widgets\Pager;

/** @var $category Category */

?>

@extends('_templates/app')
<? //var_dump($category); ?>
@section('meta-tags')
    <title><?= $category->locale('seo_title') ?></title>
    <meta keywords="<?= $category->locale('seo_keywords') ?>">
    <meta description="<?= $category->locale('seo_description') ?>">
@endsection

@section('head-css')
    @parent
    <link rel="stylesheet" href="/css/site/category/index.css">
@endsection

@section('body-class', 'body-class-category')

@section('top')

    @include('_templates/top')

    <?php

    $categories = Category::searchActive()
        ->with('image')->with('parent')
        ->where('parent_category_id', $category->id)
        ->get();


    $image = \App\Models\Image::query()->find($category->image_id);
    ?>

    <div class="sect-category-pane" style="background-image:url(<?= \App\Components\ImageManager::getPhotosUrl($image->url) ?>)">
        @include('_templates/top-menu')

        <div class="sect-category-pane__title"><?= t::getLocaleField($category, 'name') ?></div>

        <div class="container-fluid">

            <div class="container">
<!--                <div class="sect-category-pane__accordion flex-column" data-bs-toggle="collapse" type="button" data-bs-target="#sect-category-pane__id">
                    <div>Выбрать категорию</div>
                    <div type="button" id="sect-category-pane__id" class="collapse pt-1">
                        <?php foreach ($categories as $cat): ?>
                        <a class="d-block" onclick="location.href='{{ CategoryManager::getUrl($cat) }}'"
                                class="{{ $subCategory && $subCategory->id == $cat->id ? 'sect-category-pane__menu_active' : '' }}">
                            <?= t::getLocaleField($cat, 'name') ?>
                        </a>
                        <?php endforeach; ?>
                    </div>

                </div>-->
                <div class="sect-category-pane__menu flex-wrap flex-column flex-md-row d-lg-flex">
                    <a href="<?= CategoryManager::getUrl($category) ?>" class="text-gray-200 {{ !$subCategory ? 'sect-category-pane__menu_active' : '' }}">@lang('site.category.all')</a>

                    <?php foreach ($categories as $cat): ?>
                        <a href="<?= CategoryManager::getUrl($cat) ?>" class="text-gray-200 {{ $subCategory && $subCategory->id == $cat->id ? 'sect-category-pane__menu_active' : '' }}">
                            <?= t::getLocaleField($cat, 'name') ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <section class="container mt-4 mb-5">
        <div class="row">
            <?php

            const PER_PAGE = 4;

            $curPage = isset($_GET['page']) ? $_GET['page'] - 1 : 0;

            if ($subCategory) {
                $categoryIds = ['id' => $subCategory->id];
            } else {
                $categoryIds = Category::searchActive()
                    ->where('parent_category_id', $category->id)
                    ->get();

                $categoryIds = array_column($categoryIds->toArray(), 'id');
            }

            $query = DB::select('select count(*) as count from product where product.category_id in (' . join(',', $categoryIds) . ')');
            $productCount = $query[0]->count;

            $productList = Product::searchActive()
                ->with('image')
                ->whereRaw('hidden = 0 AND product.category_id in (' . join(',', $categoryIds) . ')')
                ->offset(PER_PAGE * $curPage)
                ->take(PER_PAGE)
                ->get();

            echo ProductItemList::widget([
                'productList' => $productList
            ])
            ?>
        </div>

        {{ Pager::widget([
            'totalCount' => $productCount,
            'perPage' => PER_PAGE,
            'curPage' => $curPage
        ]) }}
    </section>

    {!! CategoryInfo::widget([
        'category' => $subCategory ?? $category
    ]) !!}

@endsection
