<?php

namespace App\Repositories;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Product modelClass
 */
class ProductRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = Product::class;
    }

    public function findById(Model $id)
    {
        return new ProductResource(parent::findById($id));
    }

    public function paginate($page, $perPage)
    {
        return ProductCollection::collection($this->modelClass::forPage($page, $perPage));
    }
}
