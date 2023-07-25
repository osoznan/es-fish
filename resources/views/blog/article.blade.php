<?php

use App\Components\BlogManager;
use App\Components\ImageManager;
use App\Widgets\BreadCrumbs;

/** @var  $article \App\Models\BlogArticle */

$title = $article->locale("title");
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
        <div class="sect-category-pane__title"><?= $title ?></div>
    </div>

    <div class="container">
        <div>
            {!! BreadCrumbs::widget(['items' => [
                ['url' => BlogManager::getCategoryUrl($article->category_id), 'title' => trans('site.blog.' . BlogManager::getCategoryAlias($article->category_id))],
                ['url' => BlogManager::getUrl($article), 'title' => $article->locale('title')]
            ]]) !!}
        </div>

        <div class="blog__thumb">
            <div class="d-flex justify-content-center mb-4">
                <div class="blog__thumb__image" data-src="{{ ImageManager::getPhotosUrl($article->image->url) }}" alt="картинка статьи"></div>
            </div>
            <div class="blog__thumb__text">
                <div class="blog-thumb__description mb-3">{!! $article->locale('text') !!}</div>
            </div>
        </div>
        <div class="pb-5">&nbsp;</div>
    </div>
@endsection
