<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\Components\Translation as t;

class ProductImage extends GeneralModel {

    use HasFactory;
    use HelperTrait;
    use LocaleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'image_id',
        'image_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $table = 'product_image';

    protected $appends = [
//        'image',
//        'product'
    ];

    public $timestamps = [];

//
//    public function product() {
//        return $this->hasOne('App\Models\Product');
//    }
//
//    public function image() {
//        return $this->hasOne('App\Models\Image');
//    }

    /** @return Builder */
    public static function search() {
        return ProductImage::select([
            'product_id',
            'image_id',
            'image.url as image_url'
        ])->leftJoin('image', 'image_id', '=', 'image.id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function image() {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function getLocaleName() {
        return t::getLocaleField($this, 'name');
    }

    public static function getValidators() {
        return [
        ];
    }

}
