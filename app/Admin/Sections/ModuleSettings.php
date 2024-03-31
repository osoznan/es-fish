<?php

namespace App\Admin\Sections;

use AdminFormElement;
use App\Components\ImageManager;
use App\Models\Image;

trait ModuleSettings {

    public function getFormElementFromName($name, $field, $label): mixed {
        if ($name == 'image') {
            return AdminFormElement::selectajax($field, $label)
                ->setModelForOptions(Image::class)
                ->setSearch('name')
                ->setDisplay(function ($model) {
                    return '<a href="' . ImageManager::getPhotosUrl($model->url) . '" data-toggle="lightbox">
                                <img src="' . ImageManager::getThumbsUrl($model->url) . '" width="60" height="50">
                            </a>
                            <span style="cursor: pointer">' . $model->name . '</span>';
                });
        } elseif ($name == 'textarea') {
            return AdminFormElement::wysiwyg($field, $label);
        }

        return AdminFormElement::$name($field, $label);
    }

}
