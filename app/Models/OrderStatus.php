<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class OrderStatus extends GeneralModel {

    use HasFactory;

    const PROCESSING = 1;
    public const CACHE_KEY = 'OrderStatus-list';

    protected $fillable = [
        'name',
        'hidden',
    ];

    protected $table = 'order_status';

    public $timestamps = false;

    public static function getAllValues($key = null) {
        if (!Cache::has(static::CACHE_KEY)) {
            Cache::put(
                static::CACHE_KEY,
                OrderStatus::where('hidden', 0)
                    ->get()->keyBy('id')->toArray(),
                120
            );
        }

        $all = Cache::get(static::CACHE_KEY);

        return !$key ? $all : $all[$key];
    }
}
