<?php

namespace App\Widgets;

use App\Components\BasketManager;
use App\Components\ImageManager;
use App\Components\OrderManager;
use App\Components\ProductManager;
use App\Components\ViewInserter;
use App\Components\Widget;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductItem extends Widget {

    use AjaxWidget;

    public $product;
    public $class;

    public static function getAjaxHandlers() {
        return ['ajaxRefresh'];
    }

    public function run() {
        $product = $this->product;
        ?>

        <div class="product-thumb p-3 <?= $this->class ?>">
            <a href="<?= ProductManager::getUrl($product) ?>">
                <div style="background-image:url(<?= ImageManager::getPhotosUrl($product->image->url) ?>)" class="product-thumb__image div-image-thumb">

                </div>
            </a>
            <a href="<?= ProductManager::getUrl($product) ?>" class="product-thumb__title">
                <?= $product->locale('name') ?>
            </a>
            <div class="product-thumb__ajax-space">
                <?= $this->getUpdatedContent() ?>
            </div>
        </div>
        <?php

        ViewInserter::insertJs(<<< JS
            productItemChange = function(el, productId, delta) {
                ajaxLoad(el.closest('.product-thumb__ajax-space'), '/ajax', 'ajaxRefresh', {product_id: productId, delta: delta}, function(res) {
                    triggerEvent(document, 'cart-changed', {totalCost: res.totalCost})
                })

            }
JS, 'productAmountSelector');
    }

    public function getUpdatedContent() {
        $product = $this->product;
        $amountInBasket = BasketManager::get($product->id);

        ob_start();

        if ($product->present): ?>
            <div class="tiny-font orange-color"><?= trans('site.product.present') ?></div>
        <?php else: ?>
            <div class="tiny-font orange-color"><?= trans('site.product.not-present') ?></div>
        <?php endif ?>
        <div class="tiny-font <?= $product->old_price ? 'text-decoration-line-through' : '' ?>"><?= $product->old_price ?? '&nbsp;' ?></div>
        <div class="product-thumb__price tiny-font"><?= $amountInBasket ? $product->price * $amountInBasket : $product->price ?> <?= trans('site.abbr.hrivnas') ?></div>
        <div class="d-flex align-items-center text-center">
            <?php if ($amountInBasket): ?>
                <div class="product-thumb__selector">
                    <button data-class="minus" onclick="productItemChange(this, <?= $product->id ?>, -1)" class="dark-text-anchor_bg">-</button>
                    <input data-class="amount" value="<?= $amountInBasket ?>" onchange="productItemChange(this, <?= $product->id ?>, 1)" class="dark-text-anchor_bg">
                    <button data-class="plus" onclick="productItemChange(this, <?= $product->id ?>, 1)">+</button>
                </div>
            <?php else: ?>
                <button class="product-thumb__order button-orange" onclick="productItemChange(this, <?= $product->id ?>, 1)">
                    <img src="/img/shopping-bag-white.svg">
                    <?= trans('site.cart.send') ?>
                </button>
            <?php endif; ?>
        </div> <?php

        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public static function ajaxRefresh(Request $request, $data) {
        if (isset($data['amount'])) {
            if (is_numeric($data['amount']) && $data['amount'] >= 0) {
                BasketManager::set($data['product_id'], $data['amount']);
            }
        } elseif ($data['delta'] == 1) {
            BasketManager::add($data['product_id']);
        } elseif ($data['delta'] == -1) {
            BasketManager::remove($data['product_id']);
        }

        $product = Product::searchActive()
            ->where(['product.id' => $data['product_id']])
            ->first();

        return response()->json([
            'content' => (new ProductItem([
                'product' => $product,
                'amountError' => $amountError ?? false
            ]))->getUpdatedContent(),
            'totalCost' => OrderManager::getProductsTotalCost()
        ]);
    }
}
