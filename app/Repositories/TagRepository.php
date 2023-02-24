<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

class TagRepository implements Interfaces\TagRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tag::all();
    }

    public function getUserTags(User $user): Collection
    {
        return $user->tags;
    }

    public function getByName(User $user, string $name): ?Tag
    {
        $tags = $this->getUserTags($user);

        foreach ($tags as $tag) {
            if (strtolower($tag->name) === strtolower($name)) {
                return $tag;
            }
        }
        return null;
    }

    public function getByArticle(Article $article): Collection
    {
        return $article->tags;
    }
}
