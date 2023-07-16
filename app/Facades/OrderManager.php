<?php

namespace App\Facades;

use App\Models\Order;
use Illuminate\Support\Facades\Facade;

/**
 * @method static addOrder(array $orderData, array $cartData): array|int
 * @method static addOrderStatus($order, int $statusId, string $description = null)
 * @method static getFinalCost(array $cartData, Order $order)
 * @method static ggetDeliveryCost(float $itemsCost, $data)
 * @method static sendOrderMailToVendor(Order $order)
 * @method static getProductsTotalCost($amounts = null): float
 * @method static getOrderUnseenCount()
 */
class OrderManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'order.service';
    }
}
