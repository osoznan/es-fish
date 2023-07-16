<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\MainGallery;
use Illuminate\Support\Collection;

/**
 * @property Category modelClass
 */
class MainGalleryRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = MainGallery::class;
    }

}

