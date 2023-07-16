<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GeneralModel extends Model {

    use LocaleTrait;

    public static function searchActive(): Builder {
        return parent::query()->where(['hidden' => 0]);
    }

    public static function queryWithHidden(): Builder {
        return parent::query();
    }

}
