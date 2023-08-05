<?php

namespace App\Models;

use App\Components\Translit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Cart extends GeneralModel {

    use HasFactory;
    use LocaleTrait;

    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
    ];

    protected $hidden = [];

    protected $table = 'cart';

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
