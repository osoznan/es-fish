<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\BlogArticleController;
use App\Http\Controllers\Api\FeedbackController;
use App\Models\MainGallery;
use App\Http\Controllers\Api\OrderStatusHistoryController;
use App\Http\Controllers\Api\ProductController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('category')->group(function () {
    Route::get('', [CategoryController::class, 'list']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [CategoryController::class, 'create']);
        Route::post('/{category}', [CategoryController::class, 'store']);
        Route::delete('/{category', [CategoryController::class, 'remove']);
    });
});

Route::prefix('image')->group(function () {
    Route::get('', [ImageController::class, 'list']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [ImageController::class, 'create']);
        Route::post('/{image}', [ImageController::class, 'store']);
        Route::delete('/{image}', [ImageController::class, 'remove']);
    });
});

Route::prefix('blog')->group(function () {
    Route::get('', [BlogArticleController::class, 'list']);
    Route::get('/{id}', [BlogArticleController::class, 'view']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [BlogArticleController::class, 'create']);
        Route::post('/{blog}', [BlogArticleController::class, 'store']);
        Route::delete('/{blog}', [BlogArticleController::class, 'remove']);
    });
});

Route::prefix('feedback')->group(function () {
    Route::get('', [FeedbackController::class, 'list']);
    Route::get('/{id}', [FeedbackController::class, 'view']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [FeedbackController::class, 'create']);
        Route::post('/{feedback}', [FeedbackController::class, 'store']);
        Route::delete('/{feedback}', [FeedbackController::class, 'remove']);
    });
});

Route::prefix('gallery')->group(function () {
    Route::get('', [MainGallery::class, 'list']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [MainGallery::class, 'create']);
        Route::post('/{mainGallery}', [MainGallery::class, 'store']);
        Route::delete('/{mainGallery}', [MainGallery::class, 'remove']);
    });
});

Route::prefix('order')->group(function () {
    Route::put('', [OrderController::class, 'create']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/{order}/change-status', [OrderController::class, 'changeStatus']);
    });
});

Route::prefix('order-status-history')->group(function () {
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [OrderStatusHistoryController::class, 'create']);
        Route::get('', [OrderStatusHistoryController::class, 'list']);
    });
});

Route::prefix('product')->group(function () {
    Route::get('', [ProductController::class, 'list']);
    Route::get('/{id}', [ProductController::class, 'view']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::put('', [ProductController::class, 'create']);
        Route::post('/{product}', [ProductController::class, 'store']);
        Route::delete('/{product}', [ProductController::class, 'remove']);
    });
});

Route::middleware('auth:sanctum')->get('/hello', [OrderStatusHistoryController::class, 'hello']);
