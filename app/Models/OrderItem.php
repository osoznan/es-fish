<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class OrderItem extends GeneralModel {

    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'amount',
        'data',
    ];

    protected $hidden = [];

    public $timestamps = [];

    protected $table = 'order_item';

    /** @return Builder */
    public static function search() {
        return static::select(DB::raw('*'));
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
