<?php
use App\Components\Translation as t;
?>

<div class="cart">
    <div class="container">
        <?= $cartItemsContent ?>
    </div>
    <div class="cart__form container">
        <?php if (isset($products)): ?>
        <div id="cart-send-errors" class="bg-info text-white"></div>
        <div class="row pb-sm-2 pb-lg-3">
            <div class="col-12 col-md-6">
                    <?= trans('site.cart.name') ?>
                <div id="name-error" class="bg-danger text-white"></div>
                <input id="user_name" value="<?= $name ?? null ?>"
                       placeholder="<?= trans('site.cart.placeholders.name') ?>" class="form-control mr-2">
            </div>
            <div class="col-12 col-md-6">
                    <?= trans('site.cart.phone') ?>
                <div id="phone-error" class="bg-danger text-white"></div>
                <input id="user_phone" value="<?= $phone ?? null ?>"
                       placeholder="<?= trans('site.cart.placeholders.phone') ?>" class="form-control">
            </div>
            <div class="col-12 col-md-6 mt-3">
                    <?= trans('site.cart.payment_type_id') ?>
                <div id="payment_type_id-error" class="bg-danger text-white"></div>
                <select id="payment_type_id" class="form-control mr-2">
                    <option class="gray-color" value="">[<?= trans('site.cart.placeholders.payment_type_id') ?>]
                        <?php foreach ($paymentTypes as $type): ?>
                    <option <?= $paymentType == $type['id'] ? 'selected' : '' ?> value="<?= $type['id'] ?>"><?= t::getLocaleField($type,'name') ?>
                                                                                                                  <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-6 mt-3">
                    <?= trans('site.cart.delivery_type_id') ?>
                <div id="delivery_type_id-error" class="bg-danger text-white"></div>
                <select id="delivery_type_id" value="<?= $phone ?? null ?>" class="form-control">
                    <option class="gray-color" value="">[<?= trans('site.cart.placeholders.delivery_type_id') ?>]
                        <?php foreach ($deliveryTypes as $type): ?>
                    <option <?= $deliveryType == $type['id'] ? 'selected' : '' ?> value="<?= $type['id'] ?>"><?= t::getLocaleField($type,'name') ?>
                                                                                                                   <?php endforeach; ?>
                </select>

            </div>
        </div>
        <div class="row justify-content-center text-lg-left">
            <div class="col-md-7 col-lg-4 text-center text-lg-right">
                <button onclick="sendBigCartOrder()" class="button-orange mb-3">
                        <?= trans('site.cart.do-order') ?>
                </button>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>
