<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @property Product product
 * @property string name
 * @property string text
 * @property int rate
 * @property bool hidden
 */
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

    public function product(): BelongsTo {
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
