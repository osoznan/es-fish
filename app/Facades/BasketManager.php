<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static add($id)
 * @method static remove($id)
 * @method static removeAll($id = null)
 * @method static set($id, $amount)
 * @method static get($id)
 * @method static getAll()
 * @method static isBasketEmpty()
 * @method static getProducts($idValues = null)
 */
class BasketManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'basket.service';
    }
}
