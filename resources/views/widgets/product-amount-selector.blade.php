<?php

use App\Components\Translation as t;

if ($product->old_price): ?>
<div class="sect-product__old-price light-gray-color">
    <span><?= $product->old_price * ($amountInBasket ?? 1) ?></span> <span> <?= t::inPlace('за|за|for') ?> <?= 100 * ($amountInBasket ?? 1) . ' ' . trans('site.abbr.gramm') ?></span>
</div>
<?php endif; ?>
<span class="sect-product__price"><?= $product->price * ($amountInBasket ?? 1) ?> <?= trans('site.abbr.hrivnas') ?></span> <span class="font-weight-bold"><?= $product->weight ?> <?= t::inPlace('за|за|for') ?> <?= (100 * ($amountInBasket ?? 1)) . ' ' . trans('site.abbr.gramm') ?></span>

<div class="mb-3"></div>

<div class="product-thumb__holder d-flex align-items-center justify-content-between">
    <?php if ($amountInBasket): ?>
    <div class="product-thumb__selector">
        <a data-class="minus" onclick="productAmountSelectorChange(<?= $product->id ?>, -1)" class="dark-text-anchor_bg">-</a>
        <input data-class="amount" value="<?= $amountInBasket ?>" onchange="ajaxLoad(this.parentElement.parentElement.parentElement, '/product', 'productAmountSelectorRefresh', {product_id: <?= $product->id ?>, amount: this.value})" class="<?= isset($basketError) ? 'bg-danger' : '' ?>">
        <a data-class="plus" onclick="productAmountSelectorChange(<?= $product->id ?>, 1)" class="dark-text-anchor_bg">+</a>
    </div>
    <?php else: ?>
    <a class="product-thumb__order product-thumb__order_wide button-orange d-block" onclick="productAmountSelectorChange(<?= $product->id ?>, 1)">
        <img src="/img/shopping-bag-white.svg" width="15" align="middle">
            <?= trans('site.cart.send') ?>
    </a>
    <?php endif ?>
</div>
