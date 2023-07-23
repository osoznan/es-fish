<?php

use App\Components\Translation as t;

if (!function_exists('fishLink')) {
    function fishLink($url) {
        if (t::getLocale() != 'ru') {
            return '/' . t::getLocale() . '/' . trim($url, '/');
        }

        return '/' . trim($url, '/');
    }
}
