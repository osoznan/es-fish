<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IWriteRepository {

    function create(array $attributes): array|bool;

    function store(Model $model, array $attributes): bool;

    function remove(Model $model): bool;

}
