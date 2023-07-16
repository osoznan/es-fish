<?php

use App\Models\Category;
use App\Components\Translation as t;
use App\Components\CategoryManager;
use App\Models\Product;
use App\Widgets\BigCart;

/** @var $category Category */

?>

@extends('_templates/app')

@section('page-title', trans('site.cart.title'))

@section('head-css')
    @parent
    <link rel="stylesheet" href="/css/site/cart.css">
@endsection

@section('top')

@section('top')

    @include('_templates/top')

    <section class="sect-cart mb-4">
        @include('_templates/top-menu')

        <div class="sect-cart__pane">
            @lang('site.cart.title')
        </div>
    </section>
@endsection

@endsection

@section('content')

    <?= (new BigCart())->run() ?>

@endsection
