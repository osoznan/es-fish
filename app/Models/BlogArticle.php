<?php

namespace App\Models;

use App\Components\Translit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class BlogArticle extends GeneralModel {

    use HasFactory;
    use LocaleTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'text',
        'created_at',
        'hidden',
        'title_ua',
        'text_ua',
        'title_en',
        'text_en',
        'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    protected $casts = [
        'hidden' => 'integer',
    ];

    protected $table = 'blog_article';

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    /** @return Builder */
    public static function search() {
        return BlogArticle::select(DB::raw('blog_article.*, image.url as image_url, blog_article.category_id as category_id'))
        ->leftJoin('image', 'image_id', '=', 'image.id');
    }

    protected static function boot() {
        parent::boot();
        BlogArticle::saving(function ($model) {
            $model->alias = Translit::process($model->title, 'ru');
            $model->alias_ua = Translit::process($model->title_ua, 'ua');
            $model->alias_en = Translit::process($model->title_en, 'en');
        });
    }

}
