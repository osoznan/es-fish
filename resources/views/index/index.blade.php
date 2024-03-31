<?php

use App\Models\Product;
use App\Widgets\CategoryItem;
use App\Widgets\ProductItemList;
use App\Components\BlogManager;
use App\Models\BlogArticle;
use App\Widgets\BlogItem;
use Illuminate\Support\Collection;
use App\Models\ModuleData;
use App\Components\ImageManager;
use App\Models\Image;

/** @var $categories Collection */
/** @var $mainPageModule */

$title = config('user.site-name') . ' - ' . trans('site.main-page')

?>

@extends('_templates/app')

@section('page-title', $title)

@section('head-css')
    @parent
    <link rel="stylesheet" href="/css/site/index.css">
@endsection

@section('top')
    @include('_templates/top-main')
@endsection

@section('meta-tags')
    <title><?= $mainPageModule->locale('seo_title') ?></title>
    <meta keywords="<?= $mainPageModule->locale('seo_keywords') ?>">
    <meta description="<?= $mainPageModule->locale('seo_description') ?>">
@endsection

@section('content')

    <div class="container mb-5">
        <h2>@lang('site.index.sell-hits.title')</h2>

        <?php
        $productList = Product::searchActive()
            ->with('image')->limit(4)->get();
        ?>

        <div class="container-fluid">
            <div class="container">
                {!! ProductItemList::widget([
                    'productList' => $productList,
                ]) !!}
            </div>
        </div>

    </div>

    <section class="sect-advantages container lightest-gray-background text-center">
        <h2 class="text-uppercase">@lang('site.index.advantages.title')</h2>

        <div class="row">
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <div class="sect-advantages__image" data-src="/img/wide-choice.svg"></div>
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice1')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info1')</div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <div class="sect-advantages__image" data-src="/img/quality-guarantee.svg"></div>
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice2')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info2')</div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <div class="sect-advantages__image" data-src="/img/regular-deliver.svg"></div>
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice3')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info3')</div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <div class="sect-advantages__image" data-src="/img/good-prices.svg"></div>
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice4')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info4')</div>
            </div>
        </div>
    </section>

    <div class="sect-products container mb-5 pt-4">
        <h2>@lang('site.index.fish-&-sea-products')</h2>

        <div class="row mb-4">
            @foreach ([329, 330, 331, 332] as $categoryId)
                {!! CategoryItem::widget([
                    'category' => $categories->get($categoryId),
                    'parentCategory' => $categories->get(1),
                    'class' => 'col-sm-12 col-md-6 col-xl-3'
                ]) !!}
            @endforeach

            @foreach ([333, 334] as $categoryId)
                {!! CategoryItem::widget([
                    'category' => $categories->get($categoryId),
                    'parentCategory' => $categories->get(2),
                    'class' => 'col-sm-12 col-md-6 col-lg-6'
                ]) !!}
            @endforeach
        </div>

        <?php
        $catData = [
            ['main' => 2, 'list' => [335, 336]],
            ['main' => 3, 'list' => [337, 338]],
            ['main' => 4, 'list' => [339, 340]],
            ['main' => 5, 'list' => [341, 342, 343]],
            ['main' => 6, 'list' => [344, 345, 346, 347]],
        ]
        ?>

        @foreach ($catData as $category)
        <h2>{{ $categories->get($category['main'])->localeFieldValue('name') }}</h2>
        <div class="row mb-4">
            @foreach ($category['list'] as $categoryId)
                {!! CategoryItem::widget([
                    'category' => $categories->get($categoryId),
                    'parentCategory' => $categories->get($category['main']),
                    'class' => count($category['list']) >= 4 ?
                        'col-sm-12 col-md-6 col-lg-4 col-xl-3' : 'col-sm-12 col-md-6 col-lg-' . (12 / count($category['list']))
                ]) !!}
            @endforeach
        </div>
        @endforeach
    </div>

    <section class="sect-work-scheme container-fluid lightest-gray-background text-center pt-5 pb-5 mb-4">
        <div class="container">
            <h2 class="text-uppercase">@lang('site.index.work-scheme.title')</h2>
            <div class="work-scheme row">
                <div class="work-scheme__col col-sm-6 col-lg-3">
                    <div class="work-scheme__circle">1</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info1')</div>
                </div>
                <div class="work-scheme__col col-sm-6 col-lg-3">
                    <div class="work-scheme__circle">2</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info2')</div>
                </div>
                <div class="work-scheme__col col-sm-6 col-lg-3">
                    <div class="work-scheme__circle">3</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info3')</div>
                </div>
                <div class="work-scheme__col col-sm-6 col-lg-3">
                    <div class="work-scheme__circle">4</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info4')</div>
                </div>
            </div>
        </div>
    </section>

    <section class="sect-blog container">
        <nav class="d-flex">
            <div class="sect-blog__header">@lang('site.blog.title')</div>
            <div class="sect-blog__tabs nav" id="nav-tab" role="tablist">
                @foreach (BlogManager::CATEGORY_ALIASES['en'] as $key => $blogCategory)
                    <a class="{{ $key == 1 ? 'active' : '' }}" id="nav-{{ $blogCategory }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $blogCategory }}" type="button" role="tab" aria-controls="nav-{{ $blogCategory }}" aria-selected="{{ $key == 1 ? 'true' : 'false' }}">
                        {{ trans('site.blog.' . $blogCategory) }}
                    </a>
                @endforeach
            </div>
        </nav>
        <div class="tab-content mb-4" id="nav-tabContent">
            @foreach (BlogManager::CATEGORY_ALIASES['en'] as $key => $blogCategory)
                <div class="tab-pane fade {{ $key == 1 ? 'show active' : '' }}" id="nav-{{ $blogCategory }}" role="tabpanel" aria-labelledby="nav-{{ $blogCategory }}-tab">
                    <div class="row pt-4">
                        <?php $blogArticles = BlogArticle::query()
                            ->with('image')
                            ->where('blog_article.category_id', $key)
                            ->limit(3)->get() ?>

                        @foreach ($blogArticles as $article)
                            {!! BlogItem::widget(['article' => $article]) !!}
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <?php
    $seo = ModuleData::where('name', 'seo-mainpage-module')->first();
    $image = Image::find($seo->image);
    $seoImage = ImageManager::getPhotosUrl($image->url);

    ?>

    @include('_templates/seo-text')


@endsection
