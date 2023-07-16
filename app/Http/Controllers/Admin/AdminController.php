<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderItemsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function hello() {
        return \AdminSection::view(view('admin/index'), 'name');
    }

    public function doAjax(Request $request): JsonResponse {
        $widgetClass = $request->component;
        $action = (new $widgetClass)->runCommand($request->command, $request->params);

        return response()->json($action)->header('Content-Type', 'application/json');
    }

    public function table(OrderItemsDataTable $dataTable) {
        return $dataTable->render('admin.some');
    }

}
