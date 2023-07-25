<section class="sect-seo">
    <div class="container">
        <div class="row align-items-center">
            <div class="sect-seo__text col-12 col-lg-6">
                <div class="sect-seo__small-header text-lg-left"></div>
                <h3 class="sect-seo__header text-lg-left">{{ $seo->locale('title') }}</h3>

                {!! $seo->locale('content') !!}
            </div>
            <div class="col-12 col-lg-6">
                <div class="sect-seo__image div-with-image" style="background-image: url({{ $seoImage }})"></div>
            </div>
        </div>
    </div>
</section>
