<?php

namespace App\Repositories;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;

/**
 * @property Order modelClass
 */
class OrderRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = Order::class;
    }

    public function findById($id)
    {
        return new OrderResource(parent::findById($id));
    }

    public function paginate($page, $perPage)
    {
        return OrderCollection::collection($this->modelClass::all()->forPage($page, $perPage));
    }

    public function remove($model): bool {
        return $model->delete();
    }

}
