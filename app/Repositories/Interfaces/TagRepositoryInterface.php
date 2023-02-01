<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function getAll(): Collection;

    public function getUserTags(User $user): Collection;

    public function getTagsForArticleCollection(Collection $articles): Collection;

    public function getArticleTags(Article $article): Collection;
}
