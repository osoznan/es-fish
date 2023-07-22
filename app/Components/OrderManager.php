<?php

namespace App\Components;

use App\Components\helpers\Telegram;
use App\Facades\BasketManager;
use App\Http\Requests\OrderCreateRequest;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryType;
use Illuminate\Support\Facades\Mail;

class OrderManager {

    /**
     * Adds order into db
     * @param $orderData[] Params of order
     * @param $cartData[] Array|Collection where keys are ids of added element, values are quantity
     * @return int|array
     */
    public static function addOrder(array $orderData) {
        $idValues = array_keys($cartData = $orderData['products']);

        \Validator::validate($orderData, (new OrderCreateRequest())->rules());

        $products = Product::searchActive()
            ->whereIn('id', $idValues)
            ->get()->keyBy('id');

        // Telegram::send(json_encode($products[38]));

        // try {
            DB::beginTransaction();

            $model = new Order($orderData);

            // $model->extra_data = isset($extraData) ? str_replace('\\', '\\\\', json_encode($extraData, JSON_UNESCAPED_UNICODE)) : null;

            $model->total = static::getFinalCost($cartData, $model);

            if (!$model->save()) {
                throw new \Exception('ошибка сохранения заказа');
            }

            foreach ($cartData as $id => $amount) {
                if (isset($products[$id])) {
                    $orderItem = [
                        'order_id' => $model->id,
                        'product_id' => $id,
                        'amount' => $amount,
                        'data' => str_replace('\\', '\\\\', json_encode([
                            'category_id' => $products->get($id)->category_id ?? null,
                            'name' => $products[$id]->name,
                            'description' => $products[$id]->description,
                            'price' => $products[$id]->price,
                            'weight' => $products[$id]->weight,
                            'calc_type' => $products[$id]->calc_type
                        ], JSON_UNESCAPED_UNICODE))
                    ];

                    $orderItem = new OrderItem($orderItem);
                    if (!$orderItem->save()) {
                        Telegram::send('error');
                    }
                }
            }

            OrderManager::addOrderStatus($model, OrderStatus::PROCESSING);

            DB::commit();

            OrderManager::sendTelegramSuccessOrderMessage($model);
            // OrderManager::sendOrderMailToVendor($model);

            return $model->id;

        /*} catch(\Exception $e) {
            DB::rollBack();

            return ['error' => true];
        }*/
    }

    public static function addOrderStatus($order, int $statusId, string $description = null) {
        $newStatus = new OrderStatusHistory();
        $newStatus->order_id = $order->id;
        $newStatus->status_id = $statusId;
        $newStatus->description = $description;
        $newStatus->save();

        $order->status_id = $statusId;
        $order->save();

        return $order->id;
    }

    public static function setPaymentLogForOrder($order, $data) {
        $log = new OrderPaymentLog();
        $log->load($data);
        $log->order_id = $order ? $order->id : null;

        return $log->save();
    }

    /**
     * @param array $cartData
     * @param $order
     * @return float|int
     */
    public static function getFinalCost(array $cartData, Order $order) {
        $totalSum = OrderManager::getProductsTotalCost($cartData);
        return $totalSum + OrderManager::getDeliveryCost($totalSum, $order);
    }

    /**
     * Delivery cost
     * До 3000 грн. — стоимость доставки по Киеву — 80 грн.
     * Свыше 3000 грн. — доставка по Киеву БЕСПЛАТНО.
     * Свыше 5000 грн. — доставка по Украине БЕСПЛАТНО.
     * gets a final cost having summary cost of items
     */
    public static function getDeliveryCost(float $itemsCost, Order|array $data): int {
        $sumRanges = config('user.delivery-cost-ranges');

        $delivery = $data['delivery_type_id'];
        if ($delivery == DeliveryType::DELIVERY_KIEV) {
            if ($itemsCost < $sumRanges[0]) {
                return 80;
            }
        } elseif ($itemsCost < $sumRanges[1]) {
            return 0;
        }

        return 0;
    }

    public static function sendTelegramSuccessOrderMessage(Order $order): void {
        Telegram::send("Произведён заказ товара. Клиент: $order->name ($order->phone). "
            . "Ссылка заказа: " . env('APP_URL') . "/admin/orders/$order->id/edit");
    }

    public static function sendOrderMailToVendor(Order $order) {
        foreach([
            config("user.admin-email"),
            config("user.programmer-email")
        ] as $recipient) {
            Mail::to($recipient)
                ->send(new OrderShipped($order));
        }
    }

    public static function getProductsTotalCost($amounts = null) : float {
        $amounts = $amounts ?? BasketManager::getAll();

        if (empty($amounts)) {
            return 0;
        }

        $idValues = array_keys($amounts);

        $products = Product::searchActive()
            ->whereIn('product.id', $idValues)
            ->get();

        $total = 0;
        foreach ($products as $product) {
            if (isset($amounts[$product['id']])) {
                $total += $product['price'] * $amounts[$product->id];
            }
        }

        return $total;
    }

    public static function getOrderUnseenCount() {
        return Order::select('seen')
            ->where('seen', 0)->count();
    }

}
