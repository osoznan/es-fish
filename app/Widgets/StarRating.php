<?php

namespace App\Widgets;

use App\Components\ViewInserter;
use App\Components\Widget;
use App\Models\Product;
use Illuminate\Http\Request;

class StarRating extends Widget {

    use AjaxWidget;

    public $product_id;
    public $amount;
    public $total = 5;

    public static function getAjaxHandlers() {
        return ['ajaxAddStarRating'];
    }

    public function run() { ?>
        <div class="star-rating"> <?php
        for ($i = 0; $i < $this->total; $i++) { ?>
            <span class="star-rating__<?= $i < $this->amount ? 'on' : 'off' ?>" data-value="<?= $i + 1 ?>">&#9733;</span>
        <?php } ?>
        </div> <?php

        $this->addScripts();
    }

    public function addScripts() {
/*        ViewInserter::insertJs(<<< JS
            attachEvent('.star-rating__off', 'click', function(el) {
                ajax('/product/ajax', {
                    action: 'ajaxAddStarRating',
                    data: {
                        product_id: $this->product_id,
                        value: el.target.getAttribute('data-value')
                    }
                })
            })
JS, 'star-rating');*/
    }

/*    public static function ajaxAddStarRating(Request $request, $data) {
        $product = Product::where(['id' => $data['product_id']])->first();
        $product->rating += $data['value'];
        $result = $product->save();

        return response()->json([
            'result' => $result
        ]);
    }*/

}
