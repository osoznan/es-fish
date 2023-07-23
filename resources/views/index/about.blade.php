<?php

use App\Models\Category;
use App\Components\Translation as t;

/** @var $category Category */

$title = trans('site.menu.about')

?>

@extends('_templates/app')

@section('page-title', $title)

@section('head-css')
    @parent
@endsection

@section('top')
    @include('_templates/top')

    <section class="sect-cart mb-4 container">
        @include('_templates/top-menu')

        <div class="sect-cart__pane">
            <h1><?= $title ?></h1>
        </div>
    </section>
@endsection

@section('content')

    <div class="container">
        <?= t::inPlace('123||') ?>
    </div>

@endsection
