<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DeliveryType extends GeneralModel {

    use HasFactory;

    public const DELIVERY_KIEV = 1;
    public const DELIVERY_SELF = 2;
    public const DELIVERY_NEW_POST = 3;
    public const DELIVERY_KIEV_REGION = 4;

    public const CACHE_KEY = 'DeliveryType-list';

    protected $fillable = [
        'name',
        'name_ua',
        'name_en',
        'hidden'
    ];

    protected $table = 'delivery_type';

    public $timestamps = false;

    public static function getAllValues($key = null) {
        if (!Cache::has(static::CACHE_KEY)) {
            Cache::put(
                static::CACHE_KEY,
                DeliveryType::where('hidden', 0)->get(),
                120
            );
        }

        $all = Cache::get(static::CACHE_KEY);

        return !$key ? $all : $all[$key];
    }
}
