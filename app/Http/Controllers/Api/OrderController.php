<?php

namespace App\Http\Controllers\Api;

use App\Facades\BasketManager;
use App\Components\helpers\Telegram;
use App\Facades\OrderManager;
use App\Http\Requests\OrderChangeStatusRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller {

    public function __construct()
    {
        $this->repository = new OrderRepository();
    }

    public function create(OrderCreateRequest $request): JsonResponse {
        $ids = BasketManager::getAll();

        $result = OrderManager::addOrder($request->post(), $ids);

        if (isset($result['error'])) {
            Telegram::send('Ошибка при заказе' . json_encode($request));
            return $this->error('Ошибка при заказе');
        }

        return $this->success(['id' => $result]);
    }

    public function view(Request $request): JsonResponse {
        return $this->success(
            new OrderResource($this->repository->findById($request->id))
        );
    }

    public function remove(Order $model): JsonResponse {
        return $this->repository->remove($model) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }

    public function changeStatus(Order $order, OrderChangeStatusRequest $request): JsonResponse {
        return $this->repository->changeStatus($order, $request->status_id, $request->description) ?
            $this->success() : $this->error();
    }

}
