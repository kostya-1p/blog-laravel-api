<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function getUserCategories(User $user): Collection;

    public function getArticleCategories(Article $article): Collection;
}
