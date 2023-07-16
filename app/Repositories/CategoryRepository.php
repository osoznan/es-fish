<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

/**
 * @property Category modelClass
 */
class CategoryRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = Category::class;
    }

    public function all(): Collection
    {
       return $this->modelClass::all();
    }

    public function create(array $attributes): bool
    {
        $new = new $this->modelClass($attributes);
        return $new->save();
    }

}
