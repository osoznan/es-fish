<?php

use App\Components\BlogManager;
use App\Components\ImageManager;
use App\Widgets\BreadCrumbs;
use App\Widgets\Pager;
use Illuminate\Support\Str;

/**
 * @var $categoryId int
 * @var  $articles \App\Models\BlogArticle[]
 */

$title = BlogManager::getCategoryAlias($categoryId);

?>

@extends('_templates/app')

@section('page-title', $title)

@section('head-css')
    @parent
    <link rel="stylesheet" href="/css/site/blog/index.css">
@endsection

@section('top')

    @include('_templates/top')

    @include('_templates/top-menu')

    <div class="sect-category-pane">
        <div class="sect-category-pane__title"><?= trans("site.blog.$title") ?></div>
    </div>

    <div class="container mt-4">
        <div>
            <?= BreadCrumbs::widget(['items' => [
                ['url' => BlogManager::getCategoryUrl($categoryId), 'title' => trans('site.blog.' . BlogManager::getCategoryAlias($categoryId))],
            ]]) ?>
        </div>

        <div class="row">
            <?php foreach ($articles as $article): ?>
            <div class="blog-category__thumb col-12 col-md-6 col-xl-6">
                <div class="row">
                    <div class="col-sm-12 col-xl-5 d-flex justify-content-center">
                        <a href="<?= $href = BlogManager::getUrl($article) ?>" class="w-100">
                            <div class="blog-category__thumb__image p-2" data-src="<?= ImageManager::getPhotosUrl($article->image_url) ?>" alt="картинка статьи">
                            </div>
                        </a>
                    </div>
                    <div class="blog-category__thumb__text col-sm-12 col-xl-7">
                        <h2 class="blog-category__thumb__header">
                            <a href="{{ BlogManager::getUrl($article) }}">{{ $article->locale('title') }}</a>
                        </h2>

                        <div class="blog-category-thumb__description mb-3">
                            {!! Str::of($article->locale('text'))->limit(200) !!}
                        </div>

                       <a class="button-orange mb-3" href="{{ $href }}">Подробнее</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (!count($articles)): ?>
                <h2>Отсутствуют статьи в данной категории</h2>
            <?php endif ?>

            <?= Pager::widget([
                'totalCount' => $pager['totalCount'],
                'perPage' => $pager['perPage'],
                'curPage' => $pager['curPage']
            ]) ?>
        </div>
    </div>
@endsection
