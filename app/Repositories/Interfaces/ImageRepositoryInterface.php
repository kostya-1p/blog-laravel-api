<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;
use Illuminate\Support\Collection;

interface ImageRepositoryInterface
{
    public function getByArticle(Article $article): Collection;
}
