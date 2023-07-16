<?php

namespace App\Widgets;

use App\Components\BasketManager;
use App\Components\ProductManager;
use App\Components\ViewInserter;
use App\Components\Widget;
use App\Models\Product;
use App\Components\Translation as t;
use App\Components\ImageManager;
use App\Components\OrderManager;
use App\Models\DeliveryType;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class BigCart extends Widget {

    use AjaxWidget;

    public $mode;
    public $ids;
    public $elements;
    public $deliveryType;
    public $paymentType;
    public $products;
    public $errors;

    public static function getAjaxHandlers() {
        return ['ajaxCartRefresh'];
    }

    public function run() {
        if (BasketManager::isBasketEmpty()) { ?>
            <div class="container"><?= trans('site.cart.empty-text') ?></div><?php

            return;
        }

        ?>
        <div class="cart">
            <div class="container">
                <?= $this->displayCartTable()['content'] ?>
            </div>
            <div class="cart__form container">
                <?php if (isset($this->products)): ?>
                    <div id="cart-send-errors" class="bg-info text-white"></div>
                    <div class="row pb-sm-0 pb-lg-3">
                        <div class="col-12 col-md-6">
                            <?= trans('site.cart.name') ?>
                            <div id="name-error" class="bg-danger text-white"></div>
                            <input id="user_name" value="<?= $this->name ?? null ?>"
                                   placeholder="<?= trans('site.cart.placeholders.name') ?>" class="form-control mr-2">
                        </div>
                        <div class="col-12 col-md-6">
                            <?= trans('site.cart.phone') ?>
                            <div id="phone-error" class="bg-danger text-white"></div>
                            <input id="user_phone" value="<?= $this->phone ?? null ?>"
                                   placeholder="<?= trans('site.cart.placeholders.phone') ?>" class="form-control">
                        </div>
                        <div class="col-12 col-md-6 mt-3">
                            <?= trans('site.cart.payment_type_id') ?>
                            <div id="payment_type_id-error" class="bg-danger text-white"></div>
                            <select id="payment_type_id" class="form-control mr-2">
                                <option value="">[<?= trans('site.cart.placeholders.payment_type_id') ?>]
                                    <?php foreach (PaymentType::getAllValues() as $type): ?>
                                <option <?= $this->paymentType == $type['id'] ? 'selected' : '' ?> value="<?= $type['id'] ?>"><?= t::getLocaleField($type,'name') ?>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mt-3">
                            <?= trans('site.cart.delivery_type_id') ?>
                            <div id="delivery_type_id-error" class="bg-danger text-white"></div>
                            <select id="delivery_type_id" value="<?= $phone ?? null ?>" class="form-control">
                                <option value="">[<?= trans('site.cart.placeholders.delivery_type_id') ?>]
                                    <?php foreach (DeliveryType::getAllValues() as $type): ?>
                                <option <?= $this->deliveryType == $type['id'] ? 'selected' : '' ?> value="<?= $type['id'] ?>"><?= t::getLocaleField($type,'name') ?>
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
        <?php

        $this->script();

    }

    public function displayCartTable() {
        ob_start();

        $this->ids = BasketManager::getAll();

        $emptyBasketContent = '<div class="display-3 text-center">' . trans('site.cart.basket-empty') . '</div>';

        if (is_array($this->ids) && count($this->ids)) {
            $idValues = array_keys($this->ids);

            $this->products = BasketManager::getProducts($idValues);
        } else {
            echo $emptyBasketContent;
            return;
        }

        $totalCost = OrderManager::getProductsTotalCost($this->ids);
        $deliveryCost = OrderManager::getDeliveryCost($totalCost, ['delivery_type_id' => $this->deliveryType ?? null])
        ?>
        <table class="cart-table nano-content">
            <?php foreach ($this->products as $elem): ?>
                <tr>
                    <td>
                        <div class="cart-table__image" style="background-image:url(<?= ImageManager::getPhotosUrl($elem->url) ?>)"></div>
                    </td>
                    <td>
                        <a class="cart-table__title" href="<?= ProductManager::getUrl($elem) ?>"><?= $elem->locale('name') ?></a>

                        <div class=""><?= $elem->locale('description') ?></div>

                        <div class="mb-0 mb-md-3">
                        <span class="pr-5">
                            <?= trans('site.cart.product-amount') ?>: <?= $this->ids[$elem->id] ?> <?= trans('site.abbr.items') ?>
                        </span>
                            <span
                                class="text-danger"><?= trans('site.cart.price') ?>: <?= $elem->price * $this->ids[$elem->id] ?> <?= trans('site.abbr.hrivnas') ?></span>
                        </div>
                    </td>
                    <td class="cart-table__amount">
                        <a class="cart-table__amount__plus" onclick="sendBigCartData({product_id: <?= $elem->id ?>, delta: 1})">+</a>
                        <input class="cart-table__amount__input" value="<?= $this->ids[$elem->id] ?>"
                               data-id="<?= $elem->id ?>"
                               data-start-value="<?= $this->ids[$elem->id] ?>"
                               onblur="sendBigCartData({product_id: <?= $elem->id ?>, amount: this.value})">
                        <a class="cart-table__amount__minus" onclick="sendBigCartData({product_id: <?= $elem->id ?>, delta: -1})">-</a>
                    </td>
                </tr>
            <?php endforeach ?>

         </table>

        <div class="d-flex align-items-center col-sm-12 col-lg-8 <?= $this->mode == 'order_success' ? 'd-none' : null ?>">
            <?= trans('site.cart.total') ?>:&nbsp;
            <span class="cart__total-amount"><?= $totalCost ?></span>
            <span><?= trans('site.abbr.hrivnas') ?></span>
            <span class="font-weight-bold ml-2"><?= trans('site.cart.delivery-cost') ?>: &nbsp; <?= $deliveryCost ?></span>
        </div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();

        return [
            'content' => $result,
            'totalCost' => $totalCost
        ];
    }

    public function script() {
        ViewInserter::insertJs(<<< JS
        sendBigCartData = function(data) {
            const el = document.querySelector('.cart .container')
            const newEl = document.createElement('div')

            ajax('/ru/ajax', {action: 'ajaxCartRefresh', data: data}, function(res) {
                const data = JSON.parse(res).original;
                el.innerHTML = data.content
                triggerEvent(document, 'cart-changed', {totalCost: data.totalCost})
            })
        }

        sendBigCartOrder = function() {
            const el = document.querySelector('.cart__form')

            data = {
                name: el.querySelector('#user_name').value,
                phone: el.querySelector('#user_phone').value,
                delivery_type_id: el.querySelector('#delivery_type_id').value,
                payment_type_id: el.querySelector('#payment_type_id').value
            }

            ajax('/ru/order/order', data, function(res) {
                document.querySelector('.cart>.container').innerHTML = ''
                el.innerHTML = res

                landing.updateCartIndicators(0)
            }, function(res) {
                el.querySelectorAll('[id*="-error"]').forEach((f) => f.innerHTML = '')

                for (let [fld, err] of Object.entries(JSON.parse(res.responseText).errors)) {
                    el.querySelector('#' + fld + '-error').innerHTML = err
                }
            })
        }

JS, static::class);
        echo '</script>';
    }

    public static function ajaxCartRefresh(Request $request, $data) {
        if (isset($data['amount'])) {
            if (is_numeric($data['amount']) && $data['amount'] >= 0) {
                BasketManager::set($data['product_id'], $data['amount']);
            }
        } elseif (isset($data['delta']) && $data['delta'] == 1) {
            BasketManager::add($data['product_id']);
        } elseif (isset($data['delta']) && $data['delta'] == -1) {
            BasketManager::remove($data['product_id']);
        }

        $data = (new BigCart([
            'paymentType' => $data['paymentType'] ?? null,
            'deliveryType' => $data['deliveryType'] ?? null,
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]))->displayCartTable();

        return response()->json([
            'content' => $data['content'],
            'totalCost' => $data['totalCost']
        ]);
    }
}
?>
