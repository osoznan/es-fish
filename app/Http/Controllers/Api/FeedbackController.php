<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FeedbackCreateRequest;
use App\Http\Requests\FeedbackUpdateRequest;
use App\Http\Requests\GetModelListRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Comment;
use App\Repositories\FeedbackRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function __construct()
    {
        $this->repository = new FeedbackRepository();
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

    public function create(FeedbackCreateRequest $request): JsonResponse {
        $result = $this->repository->create($request->all());

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function store(Comment $feedback, FeedbackUpdateRequest $request): JsonResponse {
        return $this->repository->store($feedback, $request->all()) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }

    public function remove(Comment $feedback): JsonResponse {
        return $this->repository->remove($feedback) ?
            $this->success(__('Элемент обновлён успешно'))
            : $this->error(__('Ошибка обновления'));
    }


}
