<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository implements Interfaces\ArticleRepositoryInterface
{
    public function getByUser(User $user): Collection
    {
        return $user->articles;
    }

    public function getById(int $id): Article
    {
        return Article::find($id);
    }
}
