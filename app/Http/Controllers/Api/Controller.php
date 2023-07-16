<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RemoveRequest;
use App\Repositories\IReadRepository;
use App\Repositories\IWriteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const API_SUCCESS = 'success';
    const API_ERROR = 'error';

    const MAX_ITEMS_RESPONSE_LIMIT = 50;

    public string $modelClass;
    public IReadRepository|IWriteRepository $repository;

    protected function success($data = [], array|null $auxData = [], $status = 200): JsonResponse {
        Log::debug('Успешный ответ: ' . json_encode($data, 0, 3));

        if (isset($data['items'])) {
            $auxData = array_merge($data, $auxData);
            $data = $data['items'];
            unset($auxData['items']);
        }

        if (is_subclass_of($data,JsonResource::class)) {
            $data = $data->toArray(new Request());
        }

        $result = ['status' => static::API_SUCCESS];
        if (!empty($auxData)) {
            $result = array_merge($result, $auxData);
        }

        if (is_string($data)) {
            $result['message'] = $data;
        } elseif ($data || ($data !== null && !$data)) {
            $keyName = 'items';

            // если хоть какой-то ключ не int -- значит ключ данных будет "item", ибо массив не список эл-тов
            foreach (array_keys($data) as $key) {
                if (!is_numeric($key)) {
                    $keyName = 'item';
                    break;
                }
            }

            $result[$keyName] = $data;
        }

        return response()->json($result, $status);
    }

    protected function error($message = null): JsonResponse {
        return response()->json([
            'status' => static::API_ERROR,
            'message' => $message ?? 'Error'
        ]);
    }

}
