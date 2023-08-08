<?php

namespace App\Models;

use App\Components\ImageManager;
use App\Facades\Telegram;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string url
 * @property string description
 * @property string category_id
 */
class Image extends GeneralModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'description',
        'category_id'
    ];

    protected $hidden = [];

    protected $table = 'image';

    public $timestamps = false;

    public static function search() {
        return Image::select();
    }

    public function products() {
        return $this->hasMany(Product::class, 'image_id');
    }

    public function getFullUrlAttribute(): string {
        return ImageManager::getPhotosUrl($this->url);
    }

    public function setFullUrlAttribute($value) {
        $this->attributes['url'] = substr($value, strrpos($value, '/') + 1);
    }

    public function getCategoryNameAttribute() {
        return ImageManager::getCategories()[$this->category_id] ?? $this->category_id;
    }

    public function getFullThumbPathAttribute(): string {
        return ImageManager::getThumbsUrl($this->url);
    }

    protected static function boot() {
        parent::boot();

        static::saving(function (self $model) {
            $result = ImageManager::thumbCreate(
                ImageManager::imagePath($model->url),
                ImageManager::thumbPath($model->url)
            );

            Telegram::send($result ? 'image created ok' : 'image error create');
        });
    }

}
