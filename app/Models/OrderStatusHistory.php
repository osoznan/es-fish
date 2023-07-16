<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
