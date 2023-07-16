<?php

namespace App\Models;

use App\Components\Translit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class Category
 * @package App\Models
 *
 * @property string name
 * @property string alias
 * @property int parent_category_id
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
        'image_name',
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $table = 'product_category';

    public $timestamps = false;

    public static function search() {
        return Category::select([
                'product_category.id as id',
                'product_category.name as name', 'name_en', 'name_ua',
                'product_category.description as description',
                'description_en as description_en',
                'description_ua as description_ua',
                'parent_category_id',
                'image_id',
                'seo', 'seo_en', 'seo_ua',
                'hidden',
                'alias', 'alias_en', 'alias_ua',
                'image.url as image_url',
                'url',
                'main_page_present'
            ])->leftJoin('image', 'image_id', '=', 'image.id');
    }

    public static function searchTopMost() {
        return static::search()
            ->where('parent_category_id', null);
    }

    public static function getValidators() {
        return [
            'name' => 'required|max:100',
            'name_en' => 'required|max:100',
            'name_ua' => 'required|max:100',
            'description' => 'required|max:1000',
            'description_en' => 'required|max:1000',
            'description_ua' => 'required|max:1000',
            'alias' => 'required|max:200',
            'alias_en' => 'required|max:200',
            'alias_ua' => 'required|max:200',
            'seo' => 'required|max:1000',
            'seo_en' => 'required|max:1000',
            'seo_ua' => 'required|max:1000',
            'image_id' => 'required|integer',
            'parent_category_id' => 'nullable|integer',
        ];
    }

    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent() {
        return $this->belongsTo(static::class, 'parent_category_id');
    }

    public function image() {
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
