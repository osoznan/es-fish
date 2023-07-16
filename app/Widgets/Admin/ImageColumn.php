<?php

namespace App\Widgets\Admin;

use App\Components\ImageManager;
use App\Components\Widget;

class ImageColumn extends Widget {

    public string $filename;

    public function run() {
        echo '<div class="row-image">
            <a href="'.ImageManager::getPhotosUrl($this->filename).'" data-toggle="lightbox">
                <div class="thumbnail"
                    style="background:url('.ImageManager::getThumbsUrl($this->filename).') no-repeat center;width:100px;height:60px"></div>
            </a>
        </div>';
    }

}
