<?php

use App\Models\Product;
use App\Components\Translation as t;
use App\Components\CategoryManager;
use App\Components\ProductManager;
use App\Models\Category;
use App\Widgets\ProductAmountSelector;
use App\Widgets\StarRating;
use App\Widgets\ProductCarousel;
use App\Components\ViewInserter;
use App\Widgets\BlogItem;
use App\Widgets\ProductItem;
use App\Components\Widget;
use App\Widgets\BreadCrumbs;

/** @var $product Product */
/** @var $category Category */
/** @var $subCategory Category */
/** @var $feedbacks \Illuminate\Support\Collection */
/** @var $blogArticles */
/** @var $recommendedProducts */

?>

@extends('_templates/app')

@section('page-title', 'Title')

@section('head-css')
    @parent
    <link rel="stylesheet" href="/css/site/product/index.css">
@endsection

@section('top')

    @include('_templates/top')

    @include('_templates/top-menu')

    <section class="sect-product container">
        <div>
            <?= BreadCrumbs::widget(['items' => [
                ['url' => CategoryManager::getUrl($category->id), 'title' => t::getLocaleField($category, 'name')],
                ['url' => CategoryManager::getUrl($subCategory->id), 'title' => t::getLocaleField($subCategory, 'name')],
                ['url' => ProductManager::getUrl($product), 'title' => $product->locale('name')]
            ]]) ?>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-lg-7">
                {{--<div class="sect-product__image" data-src="/img/photos/<?= $product->url ?>"></div>--}}
                <?= ProductCarousel::widget(['product' => $product]) ?>
            </div>
            <div class="col-12 col-lg-5">
                <h2 class="sect-product__title"><?= $product->locale('name') ?></h2>
                <span class="tiny-font light-gray-color">@lang('site.product.artikul')</span>

                <?php if ($product->present): ?>
                    <span class="tiny-font orange-color">@lang('site.product.present')</span>
                <?php else: ?>
                    <span class="tiny-font">@lang('site.product.not-present')</span>
                <?php endif ?>

                <div class="sect-product__feedback">
                    <span class="mr-2"><?= $feedbacks->count() ?>&nbsp;<?= t::inPlace('отзывов|вiдгукiв|feedbacks') ?></span>
                    <div class="w-100"><?= StarRating::widget(['product_id' => $product->id, 'amount' => $product->rating ]) ?></div>
                    <a class="sect-product__add-feedback dark-text-anchor scroll-link" href="#nav-feedback-tab" onclick="activateFeedback({{ $product->id }})">
                        @lang('site.product.feedback.add')
                    </a>
                </div>

                <div>
                    <?= ProductAmountSelector::widget(['product' => $product]) ?>
                </div>
            </div>

        </div>
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between flex-column flex-lg-row">
                <div class="pt-4">
                    <h5>@lang('site.product.delivery-type')</h5>
                    <li class="orange-color"><span class="gray-color">Самовывоз (Киев, Борисполь)</span>
                    <li class="orange-color"><span class="gray-color">Курьер по Киеву, Борисполю</span>
                    <li class="orange-color"><span class="gray-color">"Новая почта" по Украине</span>
                </div>
                <div class="pt-4">
                    <h5>@lang('site.product.delivery-conditions')</h5>
                    <li class="orange-color"><span class="gray-color">До 3000 грн. — стоимость доставки по Киеву — 80 грн.</span>
                    <li class="orange-color"><span class="gray-color">Свыше 3000 грн. — доставка по Киеву БЕСПЛАТНО.</span>
                    <li class="orange-color"><span class="gray-color">Свыше 5000 грн. — доставка по Украине БЕСПЛАТНО.</span>
                </div>
                <div class="pt-4">
                    <h5>@lang('site.product.payment')</h5>
                    <li><span class="gray-color">Наличными при самовывозе или доставке нашим курьером</span>
                    <li><span class="gray-color">Безналичный расчет для юридических лиц</span>
                    <li><span class="gray-color">Предоплата на карту "ПриватБанка"</span>
                </div>
            </div>
        </div>

        <nav>
            <div class="sect-product__tabs nav row" id="nav-tab" role="tablist">
                <button class="col active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><div>@lang('site.product.description')</div></button>
                <button class="col" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><div>@lang('site.product.properties')</div></button>
                <button class="col" id="nav-feedback-tab" data-bs-toggle="tab" data-bs-target="#nav-feedback" type="button" role="tab" aria-controls="nav-feedback" aria-selected="false" onclick="activateFeedback(<?= $product->id ?>)">
                    <div>@lang('site.feedback.feedbacks')</div>
                </button>
            </div>
        </nav>
        <div class="tab-content mb-5" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?= $product->description ?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            </div>
            <div class="tab-pane fade" id="nav-feedback" role="tabpanel" aria-labelledby="nav-feedback-tab">
            </div>
        </div>

        <h2 class="category-list__title">@lang('site.product.we-recommend')</h2>
        <div class="row pt-4 mb-5">
            <?php
            foreach ($recommendedProducts as $product):
                echo ProductItem::widget(['product' => $product, 'class' => 'col-4']);
            endforeach;
            ?>
        </div>


        <h2 class="category-list__title">@lang('site.blog.Рецепты')</h2>
        <div class="row pt-4">
            <?php
            foreach ($blogArticles as $article):
                echo BlogItem::widget(['article' => $article]);
            endforeach;
            ?>
        </div>

    </section>

    <?php ViewInserter::insertJs(<<< JS
        addComment = function(productId) {
            ajax('/product/ajax', {action: 'addComment', data: {
                    product_id: productId,
                    name: get('.feedback__form_name').value,
                    text: get('.feedback__form_text').value,
                    rate: new FormData(get('.feedback__form')).get('rate')
                }}, function() {
                switchContent(get('.feedback__form__result'))
            }, function (res) {
                const el = get('.feedback__form')
                getAll('[id*="-error"]', el).forEach((f) => f.innerHTML = '')

                for (let [fld, err] of Object.entries(JSON.parse(res.responseText).errors)) {
                    get('#' + fld + '-error', el).innerHTML = err
                }
            })
        }

        let feedbackLoaded = false

        activateFeedback = function(id) {
            if (feedbackLoaded) { return }

            const tabs = document.getElementById('nav-tabContent').children
            const buttons = document.getElementById('nav-tab').children

            Array.from(tabs).forEach((el) => {
                el.classList.remove('active')
                el.classList.remove('show')
            })

            tabs[2].classList.add('active')
            tabs[2].classList.add('show')

            Array.from(buttons).forEach((el) => {
                el.classList.remove('active')
            })

            buttons[2].classList.add('active')

            ajaxLoad(document.getElementById('nav-feedback'), '/product/ajax', 'feedbackPanel', {id: id})

            feedbackLoaded = true
        }
JS, 'add-feedback')
    ?>

@endsection
