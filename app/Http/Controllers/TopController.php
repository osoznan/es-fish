<?php

namespace App\Http\Controllers;

use App\Components\Translation as t;

class TopController extends \Illuminate\Routing\Controller {

    use AjaxController;

    public function callAction($method, $parameters) {
        if (isset($parameters['locale'])) {
            $pref = $parameters['locale'];

            // if language prefix
            if (in_array($pref, ['ru', 'ua', 'en'])) {
                t::setLocale($pref);
            }
        } else {
            t::setLocale('ru');
        }

        return parent::callAction($method, $parameters);
    }

}
