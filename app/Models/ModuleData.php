<?php

namespace App\Models;

class ModuleData extends GeneralModel {

    use LocaleTrait;

    protected $fillable = [
        'params',
        'values'
    ];

    protected $table = 'module_data';

    protected static function boot() {
        parent::boot();

        static::retrieved(function (self $model) {
            $model->attributes['params'] = json_decode($model->attributes['params'], 1);
            $model->attributes['values'] = json_decode($model->attributes['values'], 1);

            foreach ($model->attributes['params'] as $attribute) {
                $model->attributes[$attribute['name']] = $model->values[$attribute['name']] ?? null;
            }

        });

        static::saving(function (self $model) {
            $data = [];
            foreach ($model->attributes['params'] as $attribute) {
                $data[$attribute['name']] = $model->{$attribute['name']};
                unset($model->attributes[$attribute['name']]);
            }

            $model->attributes['values'] = json_encode($data);

        });
    }

    public function __set($key, $value) {
        $this->setAttribute($key, $value);
    }

}
