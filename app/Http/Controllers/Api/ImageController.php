<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateImageRequest;
use App\Http\Requests\GetModelListRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Repositories\ImageRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function __construct() {
        $this->repository = new ImageRepository();
    }

    public function list(GetModelListRequest $request): JsonResponse {
        return $this->success($this->repository->paginate(
            $request->page ?? 1,
            $request->per_page ?? Repository::MAX_READ_COUNT
        )->toArray());
    }

    public function create(CreateImageRequest $request): JsonResponse {
        if (!file('imageFile')) {
            return $this->error('Файл не загружен');
        }

        return $this->repository->create($request->only('name', 'url', 'description', 'category_id')) ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function store(Image $model, UpdateImageRequest $request): JsonResponse {
        return $this->repository->store($model, $request->all()) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));;
    }

    public function remove(Image $model): JsonResponse {
        return $this->repository->remove($model) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }

}
