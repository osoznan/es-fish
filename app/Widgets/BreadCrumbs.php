<?php

namespace App\Widgets;

use App\Components\Translation as t;
use App\Components\Widget;

class BreadCrumbs extends Widget {

    public function run() {
        $items = [];
        $s = '<div class="breadcrumbs"><a href="/" class="dark-text-anchor">' . trans('site.main-page') . '</a>&nbsp;/&nbsp;';
        foreach ($this->items as $item) {
            $items[] = '<a href="' . $item['url'] . '" class="dark-text-anchor">' . $item['title'] . '</a>';
        }

        echo $s . join('&nbsp;/&nbsp;', $items) . '</div>';
    }

}
