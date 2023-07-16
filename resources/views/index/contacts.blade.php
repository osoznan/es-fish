<?php

use App\Models\Category;
use App\Components\Translation as t;
use App\Components\CategoryManager;
use App\Models\Product;
use App\Widgets\BigCart;
use App\Widgets\ContactForm;

/** @var $category Category */

?>

@extends('_templates/app')

@section('page-title') @lang('site.contacts.title') @endsection

@section('head-css')
    @parent
@endsection

@section('top')

@section('top')
    @include('_templates/top')

    <section class="sect-cart mb-4">
        @include('_templates/top-menu')

        <div class="sect-title__pane">
            <h1>@lang('site.contacts.title')</h1>
        </div>
    </section>
@endsection

@endsection

@section('content')

    <div class="container">
        <div class="display-5">
            <a href="tel:<?= config('user.phone.full') ?>" class="p-2"><?= config('user.phone.full') ?></a>
            <P></P>
            <a href="mailto:<?= config('user.email') ?>" class="p-2"><?= config('user.email') ?></a>
            <P></P>
            <a href="" class="p-2"><img src="/img/facebook.svg" width="50"></a>
            <P></P>
            <a href="" class="p-2"><img src="/img/linkedin.svg" width="50"></a>
            <P></P>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <h3><?= trans('site.contact-form.title') ?></h3>

                <?= ContactForm::widget(); ?>
            </div>
        </div>

    </div>

@endsection
