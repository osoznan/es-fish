<?php

namespace App\Components;

use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Support\Collection;

class CartManagerAuth {

    protected $repository;
    protected ?Collection $cachedItems;

    public function __construct() {
        $this->cart = new CartRepository();
    }

    public function add(int $id): bool {
        $cart = $this->forProduct($id);

        if (!$cart) {
            return $this->cart->create([
                'product_id' => $id,
                'amount' => 1
            ]);
        }

        return $this->cart->store($id, ['amount' => $cart['amount'] + 1]);
    }

    public function remove(int $id): ?bool {
        $cart = $this->forProduct($id);

        if (!$cart) {
            return null;
        }

        if ($cart['amount'] > 1) {
            $cart['amount'] -= 1;
        } else {
            return $this->cart->remove($id);
        }

        return $this->cart->store($id, ['amount' => $cart['amount']]);
    }

    public function removeAll($id = null): ?bool {
        $cart = $this->forProduct($id);

        if (!$cart) {
            return null;
        }

        if ($id) {
            return $this->cart->remove($id);
        } else {
            return $this->cart->removeAll();
        }
    }

    public function set($id, $amount) {
        $cart = $this->forProduct($id);

        if ($amount > 0) {
            $cart->amount = $amount;
            return $cart->save();
        } else {
            return $cart->delete();
        }
    }

    public function get($id): int {
        $cart = $this->forProduct($id);

        return $cart ? $cart['amount'] : 0;
    }

    public function getAll(): Collection {
        return $this->cachedItems = $this->cart->all();
    }

    public function getAllFromCash(): Collection {
        return $this->cachedItems ?? $this->getAll();
    }

    public function getTotalCost() {
        $cartItems = $this->getAll()->keyBy('product_id');
        $products = $this->getProducts($cartItems->pluck('product_id'))
            ->keyBy('id');

        $total = 0;

        foreach ($products as $product) {
            if (isset($cartItems[$product['id']])) {
                $total += $product['price'] * $cartItems[$product['id']]->amount;
            }
        }

        return $total;
    }

    public function isCartEmpty(): bool {
        return !count($this->cart->all());
    }

    public function getProducts($idValues = null) {
        $idValues = $idValues ?? $this->getAll()->pluck('product_id');

        return Product::searchActive()
            ->with('image')
            ->whereIn('product.id', $idValues)
            ->get();
    }

    public function forProduct(int $id): array {
        return $this->cart->forProduct($id);
    }

    public function moveToCart(array $items) {

    }

}
