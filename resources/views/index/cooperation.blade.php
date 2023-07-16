<?php

use App\Models\Category;
use App\Components\Translation as t;

/** @var $category Category */

?>

@extends('_templates/app')

@section('page-title', trans('site.cooperation.title'))

@section('head-css')
    @parent
@endsection

@section('top')
    @include('_templates/top')

    <section class="sect-cart mb-4 container">
        @include('_templates/top-menu')

        <div class="sect-cart__pane">
            <h1>@lang('site.cooperation.title')</h1>
        </div>
    </section>
@endsection

@section('content')

<div class="container">
    <div>
        <?= t::inPlace('Если Вы собрались открывать паб или пивную точку или просто желаете дополнить продукцию в уже существующий пивной магазин? Тогда наш большой ассортимент разнообразной рыбной продукции, на любой вкус и достаток, станет большим подспорьем в Вашем деле.||') ?>
        <P></P>
        <?= t::inPlace('Основным видом экономической деятельности нашей производственной компании "FishWay" явлеятся оптово-розничная продажа рыбы и морепродуктов с доставкой по всем регионам Украины.||') ?>
    </div>

    <h2><?= t::inPlace('ПОЧЕМУ ИМЕННО МЫ?||') ?></h2>
    <ul>
        <li><?= t::inPlace('Крупно- и мелкооптовые цены на всю продукцию в зависимости от уровня заказа||') ?>.</li>
        <li><?= t::inPlace('Гарантия качества от производителя||') ?>.</li>
        <li><?= t::inPlace('Сезонные скидки и постоянно действующие акции||') ?>.</li>
        <li><?= t::inPlace('Прибыль от 100% (при реализации в розничных сетях)||') ?>.</li>
        <li><?= t::inPlace('Индивидуальный подход к корпоративным клиентам||') ?>.</li>
        <li><?= t::inPlace('Дропшиппинг (прямая продажа клиенту нашей продукции под вашей торговой маркой)||') ?>.</li>
    </ul>
    <?= t::inPlace('Если Вы готовы к сотрудничеству с нами или способны сами что-то предложить, то пишите нам на электронную почту wholesale@ и наши менеджеры с свяжуться с Вами в ближайшее время||') ?>.
</div>

@endsection
