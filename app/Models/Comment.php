<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Comment extends GeneralModel
{
    use HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'text',
        'answer',
        'product_id',
        'rate',
        'hidden'
   ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    protected $table = 'comment';

    /** @return Builder */
    public static function search() {
        return Comment::select(DB::raw('*'));
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected static function boot() {
        parent::boot();
        Comment::saving(function ($model) {
            if ($model->answer != '' && !$model->answer_created_at) {
                $model->answer_created_at = date('Y-m-d H:i:s', time());
            }
        });
    }

}
