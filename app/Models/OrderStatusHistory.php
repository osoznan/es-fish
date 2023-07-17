<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class OrderStatusHistory
 * @package App\Models
 *
 * @property $order_id
 * @property $status_id
 * @property $description
 */
class OrderStatusHistory extends GeneralModel {

    protected $fillable = ['order_id', 'status_id', 'created_at', 'description'];

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    protected $table = 'order_status_history';

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function order_status() {
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }

}
