<?php

namespace App\Widgets\Admin;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Repositories\OrderRepository;
use App\Repositories\OrderStatusHistoryRepository;

class OrderStatusHistoryEditor extends \App\Components\Widget {

    public int $orderId;

    public function run() {
        $history = OrderStatusHistory::where('order_id', $this->orderId)->orderByDesc('created_at')->get();
        $statuses = OrderStatus::query()->orderBy('name')->get()->pluck('name', 'id');

        echo view('admin.widgets.order-status-history-editor', [
            'orderId' => $this->orderId,
            'items' => $history,
            'statuses' => $statuses->toArray()
        ]);
    }

    public function content($params) {
        $order = Order::find($params['order_id']);

        try {
            (new OrderRepository())->changeStatus($order, $params['status_id'], $params['description']);
        } catch (\Throwable $e) {
            return ['error' => true, 'message' => 'проверьте правильность ввода данных'];
        }

        $content = OrderStatusHistoryEditor::widget(['orderId' => $params['order_id']]);

        return [
            'content' => $content
        ];
    }

}
