<?php

namespace App\Repositories;

use App\Http\Resources\BlogArticleCollection;
use App\Http\Resources\BlogArticleResource;
use App\Models\BlogArticle;
use App\Models\Category;

/**
 * @property Category modelClass
 */
class BlogArticleRepository extends Repository implements IReadRepository, IWriteRepository {

    public function __construct()
    {
        $this->modelClass = BlogArticle::class;
    }

    public function findById($id)
    {
        return new BlogArticleResource(parent::findById($id));
    }

    public function paginate($page, $perPage)
    {
        return BlogArticleCollection::collection($this->modelClass::all()->forPage($page, $perPage));
    }

}
