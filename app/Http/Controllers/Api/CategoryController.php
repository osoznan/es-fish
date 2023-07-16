<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\GetModelListRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {

    public function __construct() {
        $this->repository = new CategoryRepository();
    }

    public function list(GetModelListRequest $request): JsonResponse {
        return $this->success($this->repository->paginate(
            $request->page ?? 1,
            $request->per_page ?? Repository::MAX_READ_COUNT
        )->toArray());
    }

    public function create(CreateCategoryRequest $request): JsonResponse {
        $result = $this->repository->create([
            'name' => $request->name,
            'parent_category_id' => $request->parent_category_id
        ]);

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function store(Category $category, UpdateCategoryRequest $request): JsonResponse {
        return $this->repository->store($category, $request->all()) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));;
    }

    public function remove(Category $model, RemoveRequest $request): JsonResponse {
        return $this->repository->remove($model) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));;
    }

}
