<?php

namespace App\Repositories;

use App\Models\OrderStatusHistory;

class OrderStatusHistoryRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct() {
        $this->modelClass = OrderStatusHistory::class;
    }

}
