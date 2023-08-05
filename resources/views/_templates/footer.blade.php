<?php

use App\Models\Category;
use App\Components\Translation as t;
use App\Components\CategoryManager;
use App\Widgets\ContactForm;
use App\Components\ViewInserter;
use App\Facades\BasketManager;

?>

<div class="container-fluid">
    <div class="container">
        <div class="footer flex-column flex-column-reverse flex-lg-row d-flex flex-grow-1 justify-content-between">
            <div class="col">
                @include('_templates/widgets/logo')

                <div class="footer__copyright">@lang('site.copyright', ['date' => date('Y')])</div>
            </div>
            <div class="col d-none d-lg-block">
                <div class="footer__item-list-header">@lang('site.menu.products')</div>
                <div class="footer__item-list">
                    <?php
                    $topCategories = Category::searchTopMost()->get();

                    foreach ($topCategories as $category) {
                        echo '<a href="' . CategoryManager::getUrl($category) . '" class="d-block">' . t::getLocaleField($category, 'name') . '</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="col pb-4">
                <div class="footer__item-list-header d-none d-lg-block">@lang('site.menu.fish-way')</div>
                <div class="footer__item-list d-flex flex-column">
                    <a href="<?= fishLink('delivery-payment') ?>">@lang('site.menu.delivery+pay')</a>
                    <a href="<?= fishLink('guarantees') ?>">@lang('site.menu.guarantees')</a>
                    <a href="<?= fishLink('product-return') ?>">@lang('site.menu.return')</a>
                    <a href="<?= fishLink('faq') ?>">@lang('site.menu.faq')</a>
                </div>
            </div>
            <div class="col pb-4">
                <div class="footer__item-list-header d-none d-lg-block">@lang('site.menu.about-company')</div>
                <div class="footer__item-list d-flex flex-column">
                    <a href="<?= fishLink('about') ?>">@lang('site.menu.about')</a>
                    <a href="<?= fishLink('contacts') ?>">@lang('site.menu.contacts')</a>
                    <a href="<?= fishLink('feedback') ?>">@lang('site.menu.feedback')</a>
                </div>
            </div>
            <div class="col pb-4">
                @include('_templates/widgets/phone')
                <a href="mailto:<?= config('user.email') ?>"><?= config('user.email') ?></a>
                <div class="mt-3">
                    <a href="{{ config('user.viber') }}"><img class="footer__social-image" src="/img/telegram.svg" alt="telegram"></a>
                    <a href="{{ config('user.instagram') }}"><img class="footer__social-image" src="/img/viber.svg" alt="viber"></a>
                </div>
            </div>
        </div>
    </div>
</div>

@if (defined('INITIAL_TOTAL_COST'))
    <div class="float-cart {{ BasketManager::isCartEmpty() ? 'd-none' : '' }}">
        <a class="d-flex" href="<?= fishLink('cart') ?>">
            <div class="p-1"><img class="float-cart__image" src="/img/shopping-bag.svg" class="m-2" alt=basket></div>
            <div>
                <div><span class="float-cart__price"><?= INITIAL_TOTAL_COST ?></span> @lang('site.abbr.hrivnas')</div>
                <span class="orange-color tiny-font">@lang("site.to-basket")</span>
            </div>
        </a>
    </div>
@endif

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><h3><?= trans('site.contact-form.title') ?></h3></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= ContactForm::widget(['id' => 'modal-contact-form']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button class="contact-form__float-invoker btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
    @lang('site.contact-form.contact-us')
</button>


<a class="scroll-to-top scroll-link" href="#page-start" title="В начало страницы" style="opacity: 0.816369; display: block;">
    <img class="scroll-to-top__image" data-src="/images/slider-nav-button.png" src="/img/slider-nav-button.png" style="animation: 286.289ms ease-in 0s 1 normal none running fadein;">
</a>

<div class="progress-indicator" style="display: none">
    <img src="/img/progress.gif">
</div>

<?php
    ViewInserter::insertJs(<<< JS
        activateContactForm = (context) => {
            floatContactForm = get('#modal-contact-form').ContactForm;
            floatContactForm.setContext(context)
        }

        get('.contact-form__float-invoker').addEventListener('click', function() {
            activateContactForm('нажато на плавающую кнопку')
        })

JS
    );
?>
