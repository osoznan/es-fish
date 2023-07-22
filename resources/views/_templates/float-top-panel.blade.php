<?php

use App\Components\Translation as t;
use App\Components\OrderManager;

define('INITIAL_TOTAL_COST', OrderManager::getProductsTotalCost());

?>

<section class="container">
    <div class="sect-top-panel">
        <div class="d-lg-none topmost-navbar-toggler-pane">
            <nav class="navbar navbar-light">
                <div class="container">
                    <button class="navbar-toggler ignore-on-doc-click" onclick="landing.showMainMenu()">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
        <div class="d-none d-xl-block">
            <a href="" class="p-2"><img src="/img/facebook.svg"></a>
            <a href=""><img src="/img/linkedin.svg"></a>
        </div>
        <div class="d-none d-md-flex">
            <div><img src="" alt=phone></div>
            <div class="text-left">
                @include('_templates/widgets/phone')
                <span class="tiny-font light-gray-color">@lang('site.index.cap.call-time')</span>
            </div>
        </div>
        <div class="col">
            @include('_templates/widgets/logo')
        </div>
        <div class="d-none d-xl-block">
            <a href="<?= route('cooperation', ['locale' => t::getLocale()]) ?>" class="dotted-underline">@lang('site.cooperation.title')</a>
        </div>
        <div class="language-select d-none d-md-block">
            <?php foreach (['ua', 'ru', 'en'] as $lang):
                if ($lang != t::getLocale()):
                    echo '<span><a href="/' . ($lang != 'ru' ? $lang : '') . '" class="dark-text-anchor">' . strtoupper($lang) . '</a></span> ';
                else:
                    echo '<span class="orange-color">' . strtoupper($lang) . '</span> ';
                endif;
            endforeach; ?>
        </div>
        <a class="sect-top-panel__basket d-flex" href="<?= route('cart', ['locale' => t::getLocale()]) ?>">
            <div><img src="/img/shopping-bag.svg" class="m-2" alt=basket></div>
            <div>
                <div class="text-left"><span class="top-cart__price"><?= INITIAL_TOTAL_COST ?></span> @lang('site.abbr.hrivnas')</div>
                <span class="orange-color tiny-font text-nowrap">@lang("site.to-basket")</span>
            </div>
        </a>
    </div>
</section>
