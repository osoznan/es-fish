<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @property $name
 * @property $phone
 * @property $payment_type_id
 * @property $delivery_type_id
 * @property $status_id
 * @property $product_name
 * @property $total
 * @property $seen
 * @property $extra_data
 */
class Order extends GeneralModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'name',
        'created_at',
        'payment_type_id',
        'delivery_type_id',
        'status_id',
        'product_name',
        'total',
        'seen',
        'extra_data'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $table = 'order';

    /** @return Builder */
    public static function search() {
        return Order::select(DB::raw('*'));
    }

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payment_type() {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }

    public function delivery_type() {
        return $this->hasOne(DeliveryType::class, 'id', 'delivery_type_id');
    }

    public function status() {
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }

}
