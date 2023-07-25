<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ModuleData;
use App\Widgets\BigCart;
use App\Widgets\ContactForm;
use App\Widgets\ProductItem;
use App\Components\Translation as t;

class SiteController extends TopController {

    public function callAction($method, $parameters) {
        $this->registerAjaxHandler(ProductItem::class);
        $this->registerAjaxHandler(BigCart::class);
        $this->registerAjaxHandler(ContactForm::class);

        return parent::callAction($method, $parameters);
    }

    public function index() {
        // dd(Category::searchActive()->get()->keyBy('id'));
        return view('index.index', [
            'categories' => Category::searchActive()->get()->keyBy('id')
        ]);
    }

    public function cart() {
        return view('index.cart');
    }

    public function page($page) {
        $model = ModuleData::where('name', $page)->first();
        if (!$model) {
            abort(404);
        }
        return view('simple-article-page', [
            'model' => $model
        ]);
    }

    public function cooperation() {
        $model = ModuleData::where('name', 'cooperation')->first();
        return view('simple-article-page', [
            'model' => $model
        ]);
    }

    public function contacts() {
        return view('index.contacts');
    }

    public function delivery() {
        $model = ModuleData::where('name', 'delivery-payment')->first();
        return view('simple-article-page', [
            'model' => $model
        ]);
    }

    public function guarantees() {
        $model = ModuleData::where('name', 'guarantees')->first();
        return view('simple-article-page', [
            'model' => $model
        ]);
    }

    public function faq() {
        $model = ModuleData::where('name', 'faq')->first();
        return view('simple-article-page', [
            'model' => $model
        ]);
    }

    public function about() {
        $model = ModuleData::where('name', 'about')->first();
        return view('simple-article-page', [
            'model' => $model
        ]);
    }

    public function feedback() {
        return view('index.feedback');
    }

}
