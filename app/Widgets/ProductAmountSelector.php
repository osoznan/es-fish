<?php

namespace App\Widgets;

use App\Components\OrderManager;
use App\Components\ViewInserter;
use App\Components\Widget;
use App\Components\Translation as t;
use App\Components\BasketManager;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAmountSelector extends Widget {

    use AjaxWidget;

    public $product;

    public static function getAjaxHandlers() {
        return ['productAmountSelectorRefresh'];
    }

    public function run() {
        if (!$product = $this->product) {
            throw new \Exception('product is not specified');
        }

        $amountInBasket = BasketManager::get($product->id);

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
        <?php

        ViewInserter::insertJs(<<< JS
            productAmountSelectorChange = function(productId, delta) {
                let data = ajaxLoad(get('.product-thumb__holder').parentElement, '/ru/product/ajax', 'productAmountSelectorRefresh', {product_id: productId, delta: delta}, function(res) {
                    triggerEvent(document, 'cart-changed', {totalCost: res.totalCost})
                })

            }
JS, 'productAmountSelectorChange');
    }

    public static function productAmountSelectorRefresh(Request $request, $data) {
        if (isset($data['amount'])) {
            if (is_numeric($data['amount']) && $data['amount'] >= 0) {
                BasketManager::set($data['product_id'], $data['amount']);
            }
        } elseif (isset($data['delta']) && $data['delta'] == 1) {
            BasketManager::add($data['product_id']);
        } elseif (isset($data['delta']) && $data['delta'] == -1) {
            BasketManager::remove($data['product_id']);
        }

        $product = Product::searchActive()
            ->where('product.id', $data['product_id'])
            ->first();

        return response()->json([
            'content' => ProductAmountSelector::widget([
                'product' => $product
            ]),
            'totalCost' => OrderManager::getProductsTotalCost()
        ]);
    }
}
