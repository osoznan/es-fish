<?php
    use App\Components\ImageManager;
?>


<div id="product_carousel" class="product-carousel carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @php $i = -1 @endphp
        @foreach ($images as $image)
            @php $i++ @endphp
            <div data-src="<?= ImageManager::getThumbsUrl(isset($image['image']) ? $image['image']['url'] : '') ?>"
                type="button" data-bs-target="#product_carousel"
                data-bs-slide-to="<?= $i ?>" class="<?= !$i ? 'active' : '' ?>" aria-current="<?= $i ? 'true' : 'false' ?>" aria-label="Slide 1"></div>
        @endforeach
    </div>
    <div class="carousel-inner">
        @php $i = 0 @endphp
        @foreach ($images as $image)
            @php $i++ @endphp
            <div class="carousel-item <?= $i == 1 ? 'active' : '' ?>">
                <div class="product-carousel__image sect-product__image"
                     data-src="<?= ImageManager::getPhotosUrl(isset($image['image']) ? $image['image']['url'] : '') ?>"></div>
            </div>
        @endforeach
    </div>
<!--            <button class="carousel-control-prev" type="button" data-bs-target="#product_carousel" data-bs-slide="prev">-->
<!--                <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--                <span class="visually-hidden">Previous</span>-->
<!--            </button>-->
<!--            <button class="carousel-control-next" type="button" data-bs-target="#product_carousel" data-bs-slide="next">-->
<!--                <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--                <span class="visually-hidden">Next</span>-->
<!--            </button>-->
</div>
