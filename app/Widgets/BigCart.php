<?php

namespace App\Widgets;

use App\Facades\BasketManager;
use App\Components\ProductManager;
use App\Components\ViewInserter;
use App\Components\Widget;
use App\Components\ImageManager;
use App\Components\OrderManager;
use App\Models\DeliveryType;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BigCart extends Widget {

    use AjaxWidget;

    public $mode;
    public Collection $ids;
    public ?int $deliveryType = null;
    public ?int $paymentType = null;
    public \Countable $products;
    public \Countable $errors;

    public static function getAjaxHandlers(): array {
        return ['ajaxCartRefresh'];
    }

    public function run() {
        if (BasketManager::isCartEmpty()) { ?>
            <div class="container"><?= trans('site.cart.empty-text') ?></div><?php
            return;
        }

        echo view('widgets.big-cart', [
            'cartItemsContent' => $this->displayCartTable()['content'],
            'products' => $this->products,
            'name' => $this->name ?? null,
            'phone' => $this->phone ?? null,
            'deliveryTypes' => DeliveryType::getAllValues(),
            'paymentTypes' => PaymentType::getAllValues(),
            'deliveryType' => $this->deliveryType ?? null,
            'paymentType' => $this->paymentType ?? null,
        ]);

        $this->script();

    }

    public function displayCartTable() {
        ob_start();

        if (BasketManager::isCartEmpty()) {
            return ['content' => '<div class="container">'.trans('site.cart.empty-text').'</div>'];
        }

        $emptyBasketContent = '<div class="display-3 text-center">' . trans('site.cart.basket-empty') . '</div>';

        if (!BasketManager::isCartEmpty()) {
            $this->ids = BasketManager::getAll();
            if (Auth::user()) {
                $this->ids = $this->ids->pluck('amount', 'product_id');
                $this->products = BasketManager::getProducts($this->ids);
            } else {
                $this->products = BasketManager::getProducts($this->ids->keys());
            }
        } else {
            echo $emptyBasketContent;
            return;
        }

        $totalCost = BasketManager::getTotalCost();
        $deliveryCost = OrderManager::getDeliveryCost($totalCost, ['delivery_type_id' => $this->deliveryType ?? null])
        ?>
        <div class="cart-table nano-content">
            <?php foreach ($this->products as $elem): ?>
            <div class="cart-table__item row">
                <div class="col-sm-5 col-lg-3">
                    <div class="cart-table__image" style="background-image:url(<?= ImageManager::getPhotosUrl($elem->image->url) ?>)"></div>
                </div>
                <div class="col-sm-7 col-lg-7">
                    <a class="cart-table__title" href="<?= ProductManager::getUrl($elem) ?>">
                        <?= $elem->locale('name') ?>
                    </a>

                    <div class=""><?= $elem->locale('description') ?></div>

                    <div class="mb-0 mb-md-3">
                    <span class="pr-5">
                        <?= trans('site.cart.product-amount') ?>: <?= $this->ids[$elem->id] ?>
                        <?= trans('site.abbr.items') ?>
                    </span>
                    <span class="text-danger"><?= trans('site.cart.price') ?>: <?= $elem->price * $this->ids[$elem->id] ?>
                        <?= trans('site.abbr.hrivnas') ?>
                    </span>
                    </div>
                </div>
                <div class="cart-table__amount col-lg-2">
                    <a class="cart-table__amount__plus" onclick="sendBigCartData({product_id: <?= $elem->id ?>, delta: 1})">+</a>
                    <input class="cart-table__amount__input" value="<?= $this->ids[$elem->id] ?>"
                           data-id="<?= $elem->id ?>"
                           data-start-value="<?= $this->ids[$elem->id] ?>"
                           onblur="sendBigCartData({product_id: <?= $elem->id ?>, amount: this.value})">
                    <a class="cart-table__amount__minus" onclick="sendBigCartData({product_id: <?= $elem->id ?>, delta: -1})">-</a>
                </div>
            </div>
            <?php endforeach ?>

         </div>

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
        ViewInserter::insertJsFile('/js/widgets/big-cart.js', static::class);
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
            'content' => $data['content'] ?? ' ',
            'totalCost' => $data['totalCost'] ?? 0
        ]);
    }
}
?>
