<?php
/** @var \App\Models\ModuleData $model */
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
        <h1>{{ $model->locale('title') }}</h1>
    </div>
</section>
@endsection

@section('content')

<div class="container">
    {!! htmlspecialchars_decode($model->locale('content')) !!}
</div>

@endsection
