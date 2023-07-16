<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Comment;

/**
 * @property Category modelClass
 */
class FeedbackRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = Comment::class;
    }

}
