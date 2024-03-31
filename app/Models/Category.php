<?php

namespace App\Models;

use App\Components\Translit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Category
 * @package App\Models
 *
 * @property string name
 * @property string alias
 * @property int parent_category_id
 * @property HasOne parent
 */
class Category extends GeneralModel {

    use HasFactory;
    use LocaleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'alias_en',
        'alias_ua',
        'image_id',
        'name_ua',
        'name_en',
        'description',
        'description_en',
        'description_ua',
        'description_ua',
        'parent_category_id',
        'hidden',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'seo_title_en',
        'seo_keywords_en',
        'seo_description_en',
        'seo_title_ua',
        'seo_keywords_ua',
        'seo_description_ua',
    ];

    protected $table = 'product_category';

    public $timestamps = false;

    public static function searchTopMost(): Builder {
        return static::searchActive()
            ->where('parent_category_id', null);
    }

    public function getDescriptionShortAttribute() {
        return Str::of($this->description)->limit(150);
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent(): HasOne {
        return $this->hasOne(static::class, 'id', 'parent_category_id');
    }

    public function image(): HasOne {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    protected static function boot() {
        parent::boot();
        Category::saving(function ($model) {
            $model->alias = Translit::process($model->name, 'ru');
            $model->alias_ua = Translit::process($model->name_ua, 'ua');
            $model->alias_en = Translit::process($model->name_en, 'en');
        });
    }

}
