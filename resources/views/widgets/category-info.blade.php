<?php

use App\Models\Category;

/** @var Category $category */

?>

<section class="sect-seo">
    <div class="container">
        <div class="row">
            <div class="sect-seo__text col-12 col-lg-6">
<!--                <div class="sect-seo__small-header text-lg-left"></div>-->
                <h3 class="sect-seo__header text-lg-left">{{ $category->locale('name') }}</h3>
                {{ $category->locale('description') }}
                </button>
            </div>
            <div class="col-12 col-lg-6">
                <div class="sect-seo__image div-image-thumb" style="background-image:url({{ $category->image->fullUrl }})"></div>
            </div>
        </div>
    </div>
</section>
