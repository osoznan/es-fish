<?php

namespace App\Http\Controllers;

use App\Components\helpers\Telegram;
use App\Components\Translation as t;

class TopController extends \Illuminate\Routing\Controller {

    use AjaxController;

    public function callAction($method, $parameters) {
        if (!request()->ajax()) {
            if (isset($parameters['locale'])) {
                $pref = $parameters['locale'];

                // if language prefix is set then it is UA or EN
                if (in_array($pref, ['ua', 'en'])) {
                    t::setLocale($pref);
                }
            } else {
                // if no prefix then lang is ru
                t::setLocale('ru');
            }
        } else {
            // установим предыд. локаль, чтобы при аякс срабатывал самый недавний язык
            t::setLocale($_SESSION['last-locale']);
        }

        return parent::callAction($method, $parameters);
    }

}
