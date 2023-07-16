<?php

namespace App\Widgets\Admin;

use App\Components\Widget;

class Accordion extends Widget {

    public static function begin($params) {
        return '<div style="border: 1px #aaa solid;display: block;padding:11px"><a href="#" onclick="$(this).next().toggle()">'.($params['title'] ?? '').'</a>
            <div style="display: none; padding: 5px">';
    }

    public static function end() {
        echo '</div></div>';
    }

}
