<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BlogArticleCreateRequest;
use App\Http\Requests\BlogArticleUpdateRequest;
use App\Http\Requests\GetModelListRequest;
use App\Models\BlogArticle;
use App\Repositories\BlogArticleRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogArticleController extends Controller {

    public function __construct()
    {
        $this->repository = new BlogArticleRepository();
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

    public function create(BlogArticleCreateRequest $request): JsonResponse {
        $result = $this->repository->create($request->all());

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function store(BlogArticle $store, BlogArticleUpdateRequest $request): JsonResponse {
        return $this->repository->store($store, $request->all()) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }
}
