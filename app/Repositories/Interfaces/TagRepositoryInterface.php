<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function getAll(): Collection;

    public function getUserTags(User $user): Collection;

    public function getByName(User $user, string $name): ?Tag;

    public function getByArticle(Article $article): Collection;
}
