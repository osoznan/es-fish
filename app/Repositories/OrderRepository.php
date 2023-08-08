<?php

namespace App\Repositories;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use DB;
use Illuminate\Support\Facades\Auth;

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

    public function forUser($page, $perPage)
    {
        return OrderCollection::collection(
            $this->modelClass::all()->/*where('user_id', Auth::user()->id)->*/forPage($page, $perPage))->toArray();
    }

    public function remove($model): bool {
        return $model->delete();
    }

    public function changeStatus(Order $model, int $statusId, string $description = null): bool {
        return DB::transaction(function() use ($model, $statusId, $description) {
            $repo = new OrderStatusHistoryRepository();
            $repo->create([
                'order_id' => $model->id, 'status_id' => $statusId, 'description' => $description
            ]);
            $model->update(['status_id' => $statusId]);

            return true;
        });
    }

}
