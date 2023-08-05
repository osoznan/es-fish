<?php

namespace App\Repositories;

use App\Components\ImageManager;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Category modelClass
 */
class ImageRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = Image::class;
    }

    public function all(): Collection
    {
        return $this->modelClass::all();
    }

    public function create(array $attributes): array|bool
    {
        $file = $attributes['file'];

        $url = date('Y-m-d_H-i-s.') . $file->getClientOriginalExtension();

        if (!ImageManager::saveImageFile($file->getRealPath(), $url)) {
            return ['message' => 'Неверный формат файла', 'status' => 'error'];
        }

        $image = new Image($attributes);
        $image->url = $attributes['url'];
        if ($image->save()) {
            return true;
        }

        return false;
    }

    public function remove($model): bool
    {
        if (ImageManager::deleteImageFile($model->url)) {
            return $model->delete();
        }

        return false;
    }

}
