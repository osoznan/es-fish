<?php

use App\Widgets\ProductItem;

/** @var $productList \App\Models\Product[] */
/** @var $categories \App\Models\Category[] */

?>

<div class="row">
<?php

foreach ($productList as $product): ?>
    <div class="col col-md-6 col-lg-3">
        {!! ProductItem::widget([
            'product' => $product,
        ]) !!} ?>
    </div>
<?php endforeach ?>
</div>

