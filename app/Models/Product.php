<?php

namespace App\Models;

use App\Components\Translit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\Components\Translation as t;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Product extends GeneralModel {

    use HasFactory;
    use HelperTrait;
    use LocaleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'old_price',
        'price',
        'weight',
        'image_id',
        'image_urls',
        'description',
        'properties',
        'hidden',
        'present',
        'calc_type',
        'alias',
        'name_en', 'name_ua',
        'description_en', 'description_ua',
        'alias_en', 'alias_ua',
        'rating',
        'seo_title', 'seo_keywords', 'seo_description',
        'seo_title_en', 'seo_keywords_en', 'seo_description_en',
        'seo_title_ua', 'seo_keywords_ua', 'seo_description_ua',
        'created_at',
        'updated_at',
        'recommended'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $table = 'product';

    protected static function boot() {
        parent::boot();
        static::saving(function (Product $model) {
            $model->alias = Translit::process($model->name, 'ru');
            $model->alias_ua = Translit::process($model->name_ua, 'ua');
            $model->alias_en = Translit::process($model->name_en, 'en');

            $model->imageIds ? $model->_saveImages($model) : null;
        });
    }

    public function getLocaleName() {
        return t::getLocaleField($this, 'name');
    }

    public function getDescriptionShortAttribute() {
        return Str::of($this->description)->limit(150);
    }

    public function category(): HasOne {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function image() {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function images() {
        return $this->belongsToMany(Image::class, 'product_image');
    }

    private function _saveImages($model) {
        ProductImage::where('product_id', $model->id)->delete();

        foreach (json_decode($model->imageIds) as $elem) {
            $image = new ProductImage();
            $image->product_id = $model->id;
            $image->image_id = $elem['id'];
            $image->save();
        }

        return true;
    }

}
