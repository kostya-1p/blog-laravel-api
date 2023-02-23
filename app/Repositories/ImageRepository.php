<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Collection;

class ImageRepository implements ImageRepositoryInterface
{
    public function getByArticle(Article $article): Collection
    {
        return $article->images;
    }
}
