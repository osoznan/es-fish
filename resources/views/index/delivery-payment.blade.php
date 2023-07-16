<?php

use App\Models\Category;
use App\Components\Translation as t;

/** @var $category Category */

$title = t::inPlace('Доставка и оплата||')

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
        <h2><?= t::inPlace('Условия доставки:') ?></h2>
        <ul>
            <li><?= t::inPlace('При заказе на сумму свыше 3000 грн. — доставка по Киеву БЕСПЛАТНО||') ?>.</li>
            <li><?= t::inPlace('При заказе на сумму до 3000 грн. — стоимость доставки по Киеву — 80 грн.||') ?></li>
            <li><?= t::inPlace('При заказе на сумму свыше 5000 грн. — доставка по Украине БЕСПЛАТНО.||') ?></li>
            <li><?= t::inPlace('При заказе на сумму до 5000 грн. по Украине — согласно тарифам перевозчика "Новая почта".||') ?></li>
        </ul>

        <h2><?= t::inPlace('Способы доставки:||') ?></h2>
        <ul>
            <li><?= t::inPlace('Самовывоз (Киев, Борисполь).||') ?></li>
            <li><?= t::inPlace('Курьер по Киеву, Борисполю.||') ?></li>
            <li><?= t::inPlace('Новая почта.||') ?></li>
            <li><?= t::inPlace('Другие способы доставки, в том числе пересылка маршрутными автобусами, оговаривается отдельно.||') ?></li>
        </ul>
        <h2><?= t::inPlace('Оплата:||') ?></h2>
        <ul>
            <li><?= t::inPlace('Наличными. Оплата наличными возможна при самовывозе товара. Или же при доставке заказа нашим курьером.||') ?></li>
            <li><?= t::inPlace('Безналичный расчет. Безналичный расчёт для юридических лиц.||') ?></li>
            <li><?= t::inPlace('редоплата на карту "ПриватБанка".||') ?></li>
            <li><?= t::inPlace('Наложенный платеж. Оплата наложенным платежом возможна при заказе товара в другие регионы Украины.||') ?></li>
        </ul>
    </div>
@endsection
