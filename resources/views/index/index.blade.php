<?php

use App\Models\Product;
use App\Widgets\CategoryItem;
use App\Widgets\ProductItemList;
use App\Components\BlogManager;
use App\Models\BlogArticle;
use App\Widgets\BlogItem;
use Illuminate\Support\Collection;

/** @var $categories Collection */

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

@section('content')

    <div class="container mb-5">
        <h2>@lang('site.index.sell-hits.title')</h2>

        <?php
        $productList = Product::searchActive()
            ->limit(4)->get();
        ?>

        <div class="container-fluid">
            <div class="container">
                <?= ProductItemList::widget([
                    'productList' => $productList
                ]) ?>
            </div>
        </div>

    </div>

    <section class="sect-advantages container lightest-gray-background text-center">
        <h2 class="text-uppercase">@lang('site.index.advantages.title')</h2>

        <div class="row">
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <img src="/img/wide-choice.svg" class="p-2">
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice1')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info1')</div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <img src="/img/wide-choice.svg" class="p-2">
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice2')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info2')</div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <img src="/img/wide-choice.svg" class="p-2">
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice3')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info3')</div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 p-4">
                <img src="/img/wide-choice.svg" class="p-2">
                <div class="fw-bold text-uppercase p-1">@lang('site.index.advantages.big-choice4')</div>
                <div class="p-2">@lang('site.index.advantages.big-choice-info4')</div>
            </div>
        </div>
    </section>

    <div class="sect-products container mb-5">
        <h2>@lang('site.index.fish-&-see-products')</h2>

        <div class="row">
            <?php foreach ([10, 12, 13, 11] as $categoryId): ?>
                <?= (new CategoryItem([
                'category' => $categories->get($categoryId),
                'parentCategory' => $categories->get(1),
                'class' => 'col-lg-3'
            ]))->run() ?>
            <?php endforeach; ?>

            <?php foreach ([14, 15] as $categoryId): ?>
                <?= (new CategoryItem([
                'category' => $categories->get($categoryId),
                'parentCategory' => $categories->get(2),
                'class' => 'col-lg-6'
            ]))->run() ?>
            <?php endforeach; ?>
        </div>

        <?php
        $catData = [
            ['main' => 3, 'list' => [20, 22]],
            ['main' => 6, 'list' => [47, 48]],
            ['main' => 7, 'list' => [68, 72]],
            ['main' => 8, 'list' => [75, 76, 77]],
            ['main' => 9, 'list' => [78, 79, 80, 81]],
        ]
        ?>

        <?php foreach ($catData as $category): ?>
        <h2><!--<!?= $categories->get($category['main'])->localeFieldValue('name') ?>--></h2>
        <div class="row">
            <?php foreach ($category['list'] as $categoryId): ?>
                    <?= (new CategoryItem([
                'category' => $categories->get($categoryId),
                'parentCategory' => $categories->get($category['main']),
                'class' => 'col-lg-' . (12 / count($category['list']))
            ]))->run() ?>
                <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <section class="sect-work-scheme container-fluid lightest-gray-background text-center mb-4">
        <div class="container">
            <h2 class="text-uppercase">@lang('site.index.work-scheme.title')</h2>
            <div class="work-scheme">
                <div>
                    <div class="work-scheme__circle">1</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info1')</div>
                </div>
                <div></div>
                <div>
                    <div class="work-scheme__circle">2</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info2')</div>
                </div>
                <div></div>
                <div>
                    <div class="work-scheme__circle">3</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info3')</div>
                </div>
                <div></div>
                <div>
                    <div class="work-scheme__circle">4</div>
                    <div class="work-scheme__text">@lang('site.index.work-scheme.info4')</div>
                </div>
                <div ></div>
            </div>
        </div>
    </section>

    <section class="sect-blog container">
        <nav class="d-flex">
            <div class="sect-blog__header">@lang('site.blog.title')</div>
            <div class="sect-blog__tabs nav" id="nav-tab" role="tablist">
                <?php foreach (BlogManager::CATEGORY_ALIASES['en'] as $key => $blogCategory): ?>
                    <a class="<?= $key == 1 ? 'active' : '' ?>" id="nav-<?= $blogCategory ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?= $blogCategory ?>" type="button" role="tab" aria-controls="nav-<?= $blogCategory ?>" aria-selected="<?= $key == 1 ? 'true' : 'false' ?>"> <?= trans('site.blog.' . $blogCategory) ?></a>
                <?php endforeach ?>
            </div>
        </nav>
        <div class="tab-content mb-4" id="nav-tabContent">
            <?php foreach (BlogManager::CATEGORY_ALIASES['en'] as $key => $blogCategory): ?>
                <div class="tab-pane fade <?= $key == 1 ? 'show active' : '' ?>" id="nav-<?= $blogCategory ?>" role="tabpanel" aria-labelledby="nav-<?= $blogCategory ?>-tab">
                    <div class="row pt-4">
                        <?php
                        $blogArticles = BlogArticle::query()
                            ->where('blog_article.category_id', $key)
                            ->limit(3)->get();

                        foreach ($blogArticles as $article):
                            echo (new BlogItem(['article' => $article]))->run();
                        endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>

    @include('_templates/seo-text')


@endsection
