<?php

namespace App\Http\Controllers;

use App\Components\BasketManager;
use App\Components\OrderManager;
use App\Models\Product;
use App\Widgets\BigCart;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends TopController {

    use ValidatesRequests;

    public function order(Request $request) {
        $validatedData = $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'phone' => 'required|min:3|max:20',
            'payment_type_id' => 'required',
            'delivery_type_id' => 'required',
        ]);

        $ids = BasketManager::getAll();

        $result = OrderManager::addOrder($request->post(), $ids);

        if (isset($result['error'])) {
            return $this->jsonRender($result);
        }

        BasketManager::removeAll();

        return view('order.order-sent');
    }
}
