<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GetModelListRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller {

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function list(GetModelListRequest $request): JsonResponse {
        return $this->success($this->repository->paginate(
            $request->page ?? 1,
            $request->per_page ?? Repository::MAX_READ_COUNT
        ));
    }

    public function view(Product $product, Request $request): JsonResponse {
        return $this->success($this->repository->findById($product));
    }

    public function create(ProductCreateRequest $request): JsonResponse {
        $result = $this->repository->create($request->all());

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function store(Product $product, ProductUpdateRequest $request): JsonResponse {
        $result = $this->repository->store($product, $request->all());

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }


}
