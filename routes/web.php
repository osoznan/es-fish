<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')
    ->get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

if (!session_id()) {
    try {
        session_start();
    } catch (Exception $e) {}
}

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|ua']], function() {
    Route::prefix('order')->group(function() {
        Route::post('/order', [OrderController::class, 'order']);
    });

    Route::prefix('/')->group(function () {
        Route::get('/', [SiteController::class, 'index']);
    });

    Route::name('cart')->prefix('/cart')->group(function () {
        Route::get('/', [SiteController::class, 'cart']);
    });

    Route::name('contacts')->prefix('/contacts')->group(function () {
        Route::get('/', [SiteController::class, 'contacts']);
    });

    Route::name('delivery-payment')->prefix('/delivery-payment')->group(function () {
        Route::get('/', [SiteController::class, 'delivery']);
    });

    Route::name('guarantees')->prefix('/guarantees')->group(function () {
        Route::get('/', [SiteController::class, 'guarantees']);
    });

    Route::name('faq')->prefix('/faq')->group(function () {
        Route::get('/', [SiteController::class, 'faq']);
    });

    Route::prefix('/cooperation')->group(function () {
        Route::get('/', [SiteController::class, 'cooperation']);
    });

    Route::prefix('about')->group(function () {
        Route::get('/', [SiteController::class, 'about']);
    });

    Route::name('feedback')->prefix('/feedback')->group(function () {
        Route::get('/', [SiteController::class, 'feedback']);
    });

    Route::prefix('/blog/{cat}/')->group(function () {
        Route::get('/', [BlogController::class, 'category']);
    });

    Route::prefix('/blog/{cat}/{article}')->group(function () {
        Route::get('/', [BlogController::class, 'article']);
    });

    Route::prefix('/{category}/{subcategory?}')->group(function () {
        Route::get('/', [CategoryController::class, 'category'])
            ->name('category');
    });

    Route::prefix('/{cat}/{subcat}/{product}')->group(function () {
        Route::get('/', [ProductController::class, 'product']);
    });
});

Route::prefix('/')->group(function () {
    Route::get('/', [SiteController::class, 'index']);
});

Route::prefix('/ajax')->group(function () {
    Route::post('/', [SiteController::class, 'actionAjax']);
});

Route::prefix('/product/ajax')->group(function () {
    Route::post('/', [ProductController::class, 'actionAjax']);
});

Route::prefix('order')->group(function() {
    Route::post('/order', [OrderController::class, 'order']);
});

Route::prefix('/')->group(function () {
    Route::get('/', [SiteController::class, 'index']);
});

Route::name('cart')->prefix('/cart')->group(function () {
    Route::get('/', [SiteController::class, 'cart']);
});

Route::name('contacts')->prefix('/contacts')->group(function () {
    Route::get('/', [SiteController::class, 'contacts']);
});

Route::group(['prefix' => '{page}', 'where' => ['page' => 'guarantees|cooperation|faq|delivery-payment|about']], function () {
    Route::get('', [SiteController::class, 'page']);
});

Route::name('feedback')->prefix('/feedback')->group(function () {
    Route::get('/', [SiteController::class, 'feedback']);
});

if (!Request::is('admin/*', 'telescope*')) {
    Route::prefix('/blog/{cat}/')->group(function () {
        Route::get('/', [BlogController::class, 'category']);
    });

    Route::prefix('/blog/{cat}/{article}')->group(function () {
        Route::get('/', [BlogController::class, 'article']);
    });

    Route::prefix('/{category}/{subcategory?}')->group(function () {
        Route::get('/', [CategoryController::class, 'category'])
            ->name('category');
    });

    Route::prefix('/{cat}/{subcat}/{product}')->group(function () {
        Route::get('/', [ProductController::class, 'product']);
    });

/*    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });*/
}

