<?php

namespace App\Widgets\Admin;

use App\Components\ImageManager;
use App\Components\Widget;
use App\Repositories\ImageRepository;
use App\Repositories\Repository;

class ImageSelector extends Widget {

    public bool $multiselect = false;
    public string $title;
    public array $value;

    public function run() {
        if ($this->value) {
            $_SESSION['admin-image-selector'] = $this->value['id'];
        }

        echo view('admin.widgets.image-selector', [
            'title' => $this->title,
            'value' => ImageManager::getPhotosUrl($this->value['url'])
        ]);
    }

    /**
     * Returns php content for the images list
     */
    public function content($params) {
        $images = (new ImageRepository())->paginate($params['page'] ?? 1, 20);

        $content = [];
        foreach ($images as $image) {
            $content[] = '<div class="image-selector__image" data-id="'.$image->id.'" style="margin: 3px;padding: 3px;">
                <a href="'.ImageManager::getPhotosUrl($image->url).'" data-toggle="lightbox">
                    <img src="'.ImageManager::getThumbsUrl($image->url).'" width="50" height="40">
                </a>
                <span style="cursor: pointer">'.$image->name.'</span>
            </div>';
        }

        return [
            'content' => join('', $content)
        ];
    }

    public function setValue($params) {
        $_SESSION['admin-image-selector'] = $params['id'];

        return [
            'result' => true
        ];
    }

    public static function getValue() {
        return $_SESSION['admin-image-selector'];
    }

}
