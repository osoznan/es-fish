<?php

use App\Components\Translation as t;


?>

@extends('_templates/app')

@section('top')
    @include('_templates/top')

    <section class="sect-cart mb-4">
        @include('_templates/top-menu')

    </section>
@endsection

@section('content')

    <div class="container">
        <h1>@lang('site.system.error.title')</h1>
        @lang('site.system.error.message-404')
    </div>

@endsection
