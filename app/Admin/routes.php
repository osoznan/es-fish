<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware('auth')->group(function () {
    Route::as('admin/login')->any('login', [AdminController::class, 'login']);
    Route::as('admin/logout')->any('logout', [AdminController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('', ['as' => 'admin.dashboard', function () {
        $content = 'Define your dashboard here.';
        return AdminSection::view($content, 'Dashboard');
    }]);

    Route::get('information', ['as' => 'admin.information', function () {
        $content = 'Define your information here.';
        return AdminSection::view($content, 'Information');
    }]);

    Route::as('admin.some')->get('do-some', [\App\Http\Controllers\Admin\AdminController::class, 'table']);

    Route::post('ajax', [\App\Http\Controllers\Admin\AdminController::class, 'doAjax']);

});

if (!session_id()) {
    try {
        session_start();
    } catch (Exception $e) {}
}
