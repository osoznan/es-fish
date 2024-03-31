<?php

namespace App\Widgets;

use Illuminate\Support\Collection;

class OrderList extends \App\Components\Widget {

    public $orders;

    function run() {
        echo view('widgets.order-list', [
            'orders' => $this->orders
        ]);
    }

}
