<?php

use App\Models\MainGallery;

$carouselSeq = MainGallery::search()->get();

?>

@extends('_templates/top')

@section('cap')
    @include('_templates/top-menu')

    <div id="top-carousel" class="top-carousel carousel slide container-fluid" data-bs-ride="carousel">
        <div class="carousel-indicators d-lg-none">
            @foreach ($carouselSeq as $key => $it)
                <button type="button" data-bs-target="#top-carousel" data-bs-slide-to="<?= $key ?>" class="<?= $key == 0? 'active': '' ?>" aria-current="<?= $key == 0? 'true': 'false' ?>" aria-label="Slide <?= $key ?>"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($carouselSeq as $key => $it)

            <div class="carousel-item <?= $key == 0? 'active': '' ?> top-carousel__slide">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 text-white text-xl-start text-center ">
                            <h1 class="top-carousel__slide__title"><?= $it->locale('title') ?></h1>
                            <div class="top-carousel__slide__description pb-lg-2">
                                <?= $it->locale('text') ?>
                            </div>
                            <div class="d-flex flex-column align-items-center flex-lg-row ">
                                <div class="top-carousel__slide__button1 button-bordered">
                                    <a href="<?= $it->link ?>">@lang('site.index.cap.detailed')</a>
                                </div>
                                <div class="top-carousel__slide__button2 button-orange m-3">
                                    <a href="" class="button" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="activateContactForm('со слайда <?= $it->locale("title") ?>')">@lang('site.index.cap.order-now')</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="top-carousel__nav-buttons d-none d-lg-inline">
            <button class="top-carousel__nav-prev" type="button" data-bs-target="#top-carousel" data-bs-slide="prev">
                <div data-src="/img/slider-nav-button.png"></div>
            </button>
            <button class="top-carousel__nav-next" type="button" data-bs-target="#top-carousel" data-bs-slide="next">
                <div data-src="/img/slider-nav-button.png"></div>
            </button>
        </div>
    </div>

@endsection
