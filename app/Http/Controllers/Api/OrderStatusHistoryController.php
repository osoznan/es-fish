<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GetModelListRequest;
use App\Http\Requests\OrderStatusHistoryCreateRequest;
use App\Http\Requests\OrderStatusHistorySetStatusRequest;
use App\Models\BlogArticle;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Repositories\OrderStatusHistoryRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class OrderStatusHistoryController extends Controller {

    public function __construct()
    {
        $this->repository = new OrderStatusHistoryRepository();
    }

    public function list(GetModelListRequest $request): JsonResponse {
        return $this->success($this->repository->paginate(
            $request->page ?? 1,
            $request->per_page ?? Repository::MAX_READ_COUNT
        ));
    }

    public function view(OrderStatusHistory $orderStatusHistory, Request $request): JsonResponse {
        return $this->success($orderStatusHistory);
    }

    public function create(OrderStatusHistoryCreateRequest $request): JsonResponse {
        $result = $this->repository->create($request->all());

        return $result ?
            $this->success(__('Элемент создан успешно'), null, 201)
            : $this->error(__('Ошибка создания'));
    }

    public function setStatus(OrderStatusHistory $orderStatusHistory, OrderStatusHistorySetStatusRequest $request): JsonResponse {
        $result = $this->repository->setStatus($orderStatusHistory, $request->status_id);
        return $result ? $this->success() : $this->error();
    }

    public function hello() {
        $this->middleware('auth:sanctum');
/*        $user = new User([
            'name' => 'admin',
            'email' => 'yuoanswami@gmail.com',
            'password' => '12345678'
        ]);
        $user->save();

        $token = $user->createToken(1)->plainTextToken;
        echo $token;*/

/*        $routes = collect(Route::getRoutes())->map(function (\Illuminate\Routing\Route $route) {
            echo $route->getControllerClass() . ' ' . $route->getActionMethod() ."\n";
        });*/
        BlogArticle::factory()->create(); die();

    }
}
