<?php

namespace App\Widgets;

use App\Components\helpers\Telegram;
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

        echo view('widgets.product-amount-selector', [
            'product' => $this->product,
            'amountInBasket' => BasketManager::get($product->id)
        ]);

        ViewInserter::insertJsFile('/js/widgets/product-amount-selector.js', self::class);
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
            'totalCost' => OrderManager::getProductsTotalCost(),
            'count' => BasketManager::get((int)$data['product_id'])
        ]);
    }
}
