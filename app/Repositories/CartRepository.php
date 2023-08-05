<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartRepository extends \App\Repositories\Repository {

    public function __construct()
    {
        $this->modelClass = Cart::class;
    }

    public function all(): Collection {
        return $this->modelClass::where('user_id', Auth::user()->id)->get();
    }

    public function create(array $attributes): array|bool
    {
        $new = new $this->modelClass(array_merge(['user_id' => Auth::user()->id], $attributes));
        return $new->save();
    }

    public function forProduct($id): array {
        return $this->modelClass::where('user_id', Auth::user()->id)
            ->where('product_id', $id)->first()?->attributesToArray() ?? [];
    }

    public function store($model, $attributes): bool {
        return $this->modelClass::where('user_id', Auth::user()->id)
            ->where('product_id', !is_int($model) ? $model->id : $model)
            ->update($attributes);
    }

    public function remove($model): bool {
        return $this->modelClass::where('user_id', Auth::user()->id)
            ->where('product_id', is_int($model) ? $model : $model->id)->delete();
    }

    public function removeAll(): bool {
        return $this->modelClass::where('user', auth()->id)->delete();
    }

}
