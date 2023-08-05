<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MainGallery extends GeneralModel {

    use LocaleTrait;

    protected $fillable = [
        'title', 'title_ua', 'title_en',
        'text', 'text_ua', 'text_en',
        'link',
    ];

    protected $hidden = [];

    public $timestamps = [];

    protected $table = 'main_gallery';

    public function image(): HasOne {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

}
