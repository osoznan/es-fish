<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentType extends GeneralModel {

    use HasFactory;

    public const CACHE_KEY = 'PaymentType-list';

    protected $fillable = [
        'name',
        'name_ua',
        'name_en',
        'hidden'
    ];

    protected $table = 'payment_type';

    public $timestamps = false;

    public static function getAllValues($key = null) {
        if (!Cache::has(static::CACHE_KEY)) {
            Cache::put(
                static::CACHE_KEY,
                PaymentType::where('hidden', 0)
                    ->get()->keyBy('id')->toArray(),
                120
            );
        }

        $all = Cache::get(static::CACHE_KEY);

        return !$key ? $all : $all[$key];
    }
}
