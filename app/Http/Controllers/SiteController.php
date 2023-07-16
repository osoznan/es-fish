<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    public function cooperation() {
        return view('index.cooperation');
    }

    public function contacts() {
        return view('index.contacts');
    }

    public function delivery() {
        return view('index.delivery-payment');
    }

    public function guarantees() {
        return view('index.guarantees');
    }

    public function faq() {
        return view('index.faq');
    }

    public function about() {
        return view('index.about');
    }

    public function feedback() {
        return view('index.feedback');
    }

}
