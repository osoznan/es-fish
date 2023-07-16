<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IReadRepository {

    function all(): Collection;

    function findById(Model $id);

    function paginate($page, $perPage);

}
