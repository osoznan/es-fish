<?php

use App\Models\Category;
use App\Widgets\ContactForm;

/** @var $category Category */

?>

@extends('_templates/app')

@section('page-title') @lang('site.contacts.title') @endsection

@section('head-css')
    @parent
@endsection

@section('top')
    @include('_templates/top')

    <section class="sect-cart mb-4">
        @include('_templates/top-menu')

        <div class="sect-title__pane">
            <h1>@lang('site.contacts.title')</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="container">
        <div class="contacts-pane row align-items-baseline text-center p-4 bordered-child-cells">
            <a class="col" href="tel:{{ config('user.phone.full')  }}" class="contacts-pane__link"><nobr><?= config('user.phone.full') ?></nobr></a>
            <a class="col" href="mailto:{{ config('user.email') }}" class="contacts-pane__link"><?= config('user.email') ?></a>
            <a class="col" href="{{ config('user.facebook') }}" class="contacts-pane__link"><img src="/img/facebook.svg" width="20" alt="facebook"></a>
            <a class="col" href="{{ config('user.linkedin') }}" class="contacts-pane__link"><img src="/img/linkedin.svg" width="30" alt="LinkedIn"></a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <h3><?= trans('site.contact-form.title') ?></h3>

                {!! ContactForm::widget() !!}
            </div>
        </div>

    </div>

@endsection
