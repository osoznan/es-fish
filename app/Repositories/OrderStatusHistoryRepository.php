<?php

namespace App\Repositories;

use App\Models\OrderStatusHistory;

class OrderStatusHistoryRepository extends Repository implements IReadRepository, IWriteRepository {

    public function setStatus(OrderStatusHistory $model, int $statusId): bool {
        $model->status_id = $statusId;
        return $model->save();
    }

}
