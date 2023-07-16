<?php

namespace App\Components;

use App\Models\Product;

class BasketManager {

    const SESSION_VAR = 'basket-products';

    public static function add($id) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        $data[$id] = ($data[$id] ?? 0) + 1;
        $_SESSION[static::SESSION_VAR] = $data;
    }

    public static function remove($id) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        if (!isset($data[$id])) {
            return;
        }

        if ($data[$id] > 1) {
            $data[$id] -= 1;
        } else {
            unset($data[$id]);
        }

        $_SESSION[static::SESSION_VAR] = $data;
    }

    public static function removeAll($id = null) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        if ($id) {
            unset($data[$id]);
        } else {
            $data = [];
        }

        $_SESSION[static::SESSION_VAR] = $data;
    }

    public static function set($id, $amount) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        if ($amount > 0) {
            $data[$id] = $amount;
        } else {
            unset($data[$id]);
        }

        $_SESSION[static::SESSION_VAR] = $data;
    }

    public static function get($id) {
        return isset($_SESSION[static::SESSION_VAR][$id]) ? $_SESSION[static::SESSION_VAR][$id] : null;
    }

    public static function getAll() {
        return $_SESSION[static::SESSION_VAR] ?? [];
    }

    public static function isBasketEmpty() {
        return empty(static::getAll());
    }

    public static function getProducts($idValues = null) {
        $idValues = $idValues ?? BasketManager::getAll();

        return Product::searchActive()
            ->whereIn('product.id', $idValues)
            ->get();
    }

}
