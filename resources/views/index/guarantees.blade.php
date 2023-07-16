<?php

use App\Models\Category;
use App\Components\Translation as t;

/** @var $category Category */

$title = t::inPlace('Гарантии качества||')

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
        <?= t::inPlace('Наш оптово-розничный магазин является официальным информационным ресурсом производственной компании "FishWay", специализирующейся на поставках морепродуктов по всей территории Украины. Вся представленная на сайте рыба и морепродукты исключительно высокого качества. Все продукты проходят самый тщательный отбор вручную, что позволяет избежать даже самых незначительных дефектов и изъянов.||') ?>
    </div>

@endsection
