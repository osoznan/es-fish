<?php

namespace App\Components;

use App\Models\Product;
use Illuminate\Support\Collection;

class BasketManager {

    const SESSION_VAR = 'basket-products';

    public function add($id) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        $data[$id] = ($data[$id] ?? 0) + 1;
        $_SESSION[static::SESSION_VAR] = $data;
    }

    public function remove($id) {
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

    public function removeAll($id = null) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        if ($id) {
            unset($data[$id]);
        } else {
            $data = [];
        }

        $_SESSION[static::SESSION_VAR] = $data;
    }

    public function set($id, $amount) {
        $data = $_SESSION[static::SESSION_VAR] ?? [];
        if ($amount > 0) {
            $data[$id] = $amount;
        } else {
            unset($data[$id]);
        }

        $_SESSION[static::SESSION_VAR] = $data;
    }

    public function get($id) {
        return $_SESSION[static::SESSION_VAR][$id] ?? null;
    }
    public function getAll(): Collection {
        return new Collection($_SESSION[static::SESSION_VAR] ?? []);
    }

    public function isCartEmpty() {
        return static::getAll()->isEmpty();
    }

    public function getTotalCost() {
        $amounts = $this->getAll();
        if (empty($amounts)) {
            return 0;
        }

        $products = $this->getProducts($amounts->keys());

        $total = 0;
        foreach ($products as $product) {
            if (isset($amounts[$product['id']])) {
                $total += $product['price'] * $amounts[$product->id];
            }
        }

        return $total;
    }

    public function getProducts($idValues = null) {
        $idValues = $idValues ?? BasketManager::getAll();

        return Product::searchActive()
            ->with('image')
            ->whereIn('product.id', $idValues)
            ->get();
    }

}
