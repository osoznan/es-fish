@php

use App\Components\OrderManager;

define('INITIAL_TOTAL_COST', OrderManager::getProductsTotalCost());

@endphp

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
            <a href="{{ config('user.facebook') }}" class="p-2"><img src="/img/facebook.svg" alt="facebook"></a>
            <a href="{{ config('user.linkedin') }}"><img src="/img/linkedin.svg" alt="LinkedIn"></a>
        </div>
        <div class="d-none d-md-flex">
            <div><img src="/img/phone.svg" width="35" alt="phone"></div>
            <div class="text-left">
                @include('_templates/widgets/phone')
                <span class="tiny-font light-gray-color">@lang('site.index.cap.call-time')</span>
            </div>
        </div>
        <div class="col">
            @include('_templates/widgets/logo')
        </div>
        <div class="d-none d-xl-block">
            <a href="{{ fishLink('cooperation') }}" class="dotted-underline">@lang('site.cooperation.title')</a>
        </div>
        <div class="language-select d-none d-md-flex">
            @foreach (['ua', 'ru', 'en'] as $lang)
                @if ($lang != app()->getLocale())
                    <span class="language-select__thumb"><a href="/{{ $lang != 'ru' ? $lang : '' }}" class="dark-text-anchor">{{ strtoupper($lang) }}</a></span>
                @else
                    <span class="language-select__thumb orange-color">{{ strtoupper($lang) }}</span>
                @endif
            @endforeach
        </div>
        <a class="sect-top-panel__cart d-flex" href="{{ fishLink('cart') }}">
            <div><img class="sect-top-panel__cart__image" src="/img/shopping-bag.svg" class="m-2" alt="cart"></div>
            <div>
                <div class="text-left"><span class="top-cart__price">{{ INITIAL_TOTAL_COST }}</span> @lang('site.abbr.hrivnas')</div>
                <span class="orange-color tiny-font text-nowrap">@lang("site.to-basket")</span>
            </div>
        </a>
        <div class="d-inline-block p-2">
            @if (!Auth::user())
                <a href="/login" class="alert-link">@lang('Вход')</a>
            @else
                <a href="/logout">@lang('Выйти')</a>
            @endif
        </div>
    </div>
</section>
