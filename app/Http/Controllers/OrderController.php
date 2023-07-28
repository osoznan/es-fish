<?php

namespace App\Http\Controllers;

use App\Components\BasketManager;
use App\Components\helpers\Telegram;
use App\Components\OrderManager;
use App\Http\Requests\OrderCreateRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends TopController {

    use ValidatesRequests;

    public function order(Request $request) {
        // получаем данные по товарам заказа из сессии
        $ids = BasketManager::getAll();

        $this->validate(
            $request->merge(['products' => $ids]),
            ($orderRequest = new OrderCreateRequest())->rules(),
            $orderRequest->messages(),
            $orderRequest->attributes()
        );

        $result = OrderManager::addOrder($request->all());

        if (isset($result['error'])) {
            return $this->jsonRender($result);
        }

        // BasketManager::removeAll();

        return view('order.order-sent');
    }
}
