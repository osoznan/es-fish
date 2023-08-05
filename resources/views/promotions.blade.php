<?php

use App\Widgets\ProductItemList;

/** @var \Illuminate\Support\Collection $promotions\ */


?>

@extends('_templates/app')

@section('body-class', 'body-class-category')

@section('page-title', trans('site.promotions.title'))

@section('head-css')
    @parent
    <link rel="stylesheet" href="/css/site/category/index.css">
@endsection

@section('top')

    @include('_templates/top')

    <div class="sect-category-pane">
        @include('_templates/top-menu')

        <div class="sect-category-pane__title">{{ __('site.promotions.title') }}</div>

    </div>
@endsection

@section('content')

<div class="container">
    <div class="container mb-5">
        <div class="container-fluid">
            <div class="container">
                {!! ProductItemList::widget([
                    'productList' => $promotions,
                ]) !!}
            </div>
        </div>

    </div>
</div>

@endsection
