<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property string modelClass
 */
class Repository implements IReadRepository {

    const MAX_READ_COUNT = 10000;

    public string $modelClass;

    public function all(): Collection
    {
        return $this->modelClass::all();
    }

    public function create(array $attributes): array|bool
    {
        $new = new $this->modelClass($attributes);
        return $new->save();
    }

    public function findById(Model $id)
    {
        return $this->modelClass::whereKey($id);
    }

    public function paginate($page, $perPage)
    {
    //    echo Category::query()->find(); die();
        return $this->modelClass::all()->forPage($page, $perPage);
    }

    public function store(Model|int $model, array $attributes): bool {
        return $model::update($attributes);
    }

    public function remove(mixed $model): bool
    {
        return $model::delete();
    }

}
