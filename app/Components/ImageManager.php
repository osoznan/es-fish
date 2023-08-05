<?php

namespace App\Components;

use App\Models\Image;
use phpDocumentor\Reflection\Types\Static_;

class ImageManager {

    const DEFAULT_THUMB_WIDTH = 100;

    public static function getCategories() {
        return [
            '1' => 'Товары',
            '2' => 'Категории',
            '3' => 'Блог',
            '4' => 'Галерея'
        ];
    }

    public static function imagePath($filename = null) {
        return static::getPhotosPath() . ($filename ?? null);
    }

    public static function thumbPath($filename = null) {
        return static::getThumbsPath() . ($filename ?? null);
    }

    public static function saveImageFile($from, $to): bool {
        copy($from, $newImage = self::imagePath($to));
        if (!static::thumbCreate($newImage, self::thumbPath($to), static::DEFAULT_THUMB_WIDTH)) {
            static::deleteImageFile($to);

            return false;
        }

        return true;
    }

    public static function deleteImageFile($filename): bool {
        @unlink(self::thumbPath($filename));
        return unlink(self::imagePath($filename));
    }

    public static function thumbCreate($source, $dest, $thumb_width = null): bool {
        $size = getimagesize($source);
        if (!$size) {
            return false;
        }

        list($width,$height) = $size;

        $thumb_width = $thumb_width ?? static::DEFAULT_THUMB_WIDTH;

        if ($width >= $height) {
            $thumb_height = intval($thumb_width * $height / $width);
        } else {
            $thumb_height = $thumb_width;
            $thumb_width *= $width / $height;
        }


        $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
        $fileExt = pathinfo($source)['extension'];

        switch($fileExt){
            case 'jpg':
                $source = imagecreatefromjpeg($source);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($source);
                break;

            case 'png':
                $source = imagecreatefrompng($source);
                break;
            case 'gif':
                $source = imagecreatefromgif($source);
                break;
            default:
                return false;
        }

        imagecopyresized($thumb_create,$source,0,0,0,0, $thumb_width, $thumb_height, $width, $height);

        $file = fopen($dest, 'w');
        fclose($file);

        switch($fileExt){
            case 'jpg':
            case 'jpeg':
                return imagejpeg($thumb_create, $dest,70);
                break;
            case 'png':
                return imagepng($thumb_create, $dest,3);
                break;
            default:
                return imagejpeg($thumb_create, $dest,70);
        }
    }

    public static function imageExist($filename) {
        if (file_exists(static::getPhotosPath() . $filename)) {
            return true;
        }
        return false;
    }

    public static function thumbExist($filename) {
        if (file_exists(static::getThumbsPath() . $filename)) {
            return true;
        }
        return false;
    }

    public static function getPhotosPath() {
        return public_path('img/photos/');
    }

    public static function getThumbsPath() {
        return public_path('img/thumbs/');
    }

    public static function getPhotosUrl($filename = null) {
        return '/img/photos/' . $filename;
    }

    public static function getThumbsUrl($filename = null) {
        return '/img/thumbs/' . $filename;
    }
}
