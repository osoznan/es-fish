<?php

use App\Widgets\OrderList;
use App\Components\ViewInserter;

/** @var \App\Models\ModuleData $user */
?>

@extends('_templates/app')

@section('page-title', trans('Profile'))

@section('head-css')
    @parent
@endsection

@section('top')
    @include('_templates/top')

    <section class="sect-cart mb-4 container">
        @include('_templates/top-menu')

        <div class="sect-cart__pane">
            <h1>@lang('Profile')</h1>
        </div>
    </section>
@endsection

@section('content')

<div class="container">
@if ($flashMessage)
    <div class="alert alert-primary alert-dismissible fade show">
        {{ $flashMessage }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    @lang('Login'): {{ $user->name }}
                </li>
                <li class="list-group-item">
                    @lang('Email'): {{ $user->email }}
                </li>

                @if ($user->hasVerifiedEmail())
                    <li class="list-group-item text text-info">
                        @lang('Verified User')
                    </li>
                @else
                    <li class="list-group-item">
                        <div class="text text-warning">@lang('Ваш email не верифицирован')</div>
                        <form class="verification-form d-block" method="POST" onclick="return false" action="http://fishway/verify/resend">
                            @csrf
                            <button href="/verify" type="submit" class="btn btn-light">@lang('Отправить ссылку для подтверждения верификации')</button>
                        </form>
                        <div class="verification-form__ok-message alert alert-info d-none">@lang('Подтверждение выслано на вашу почту')</div>
                    </li>
                @endif
        {{--        <li class="list-group-item">
                    <b>@lang('Сброс пароля')</b>
                    {!! Form::begin(['class' => 'password-confirm', 'onclick' => 'return false']) !!}
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::input(Form::INPUT_PASSWORD, 'password', trans('Подтверждение пароля'), '', ['class' => 'form-control', 'required' => 1, 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    {!! Form::end() !!}
                </li>--}}
            </ul>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        {!! OrderList::widget(['orders' => $orders]) !!}
    </div>
</div>

@php ViewInserter::insertJsFile('/js/profile.js') @endphp

@endsection
