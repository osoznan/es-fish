<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GetModelListRequest;
use App\Http\Requests\MainGalleryCreateRequest;
use App\Http\Requests\MainGalleryUpdateRequest;
use App\Models\MainGallery;
use App\Repositories\MainGalleryRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainGalleryController extends \App\Http\Controllers\Api\Controller {

    public function __construct()
    {
        $this->repository = new MainGalleryRepository();
    }

    public function list(GetModelListRequest $request): JsonResponse {
        return $this->success($this->repository->paginate(
            $request->page ?? 1,
            $request->per_page ?? Repository::MAX_READ_COUNT
        ));
    }

    public function view(Request $request): JsonResponse {
        return $this->success($this->repository->findById($request->id));
    }

    public function create(MainGalleryCreateRequest $request): JsonResponse {
        $result = $this->repository->create($request->all());

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function store(MainGallery $mainGallery, MainGalleryUpdateRequest $request): JsonResponse {
        return $this->repository->store($mainGallery, $request->all()) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }

    public function remove(MainGallery $mainGallery): JsonResponse {
        return $this->repository->remove($mainGallery) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }

}
