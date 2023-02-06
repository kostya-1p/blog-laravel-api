<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagService
{
    public function make(string $name, int $userId): Tag
    {
        return Tag::create([
            'name' => $name,
            'user_id' => $userId,
        ]);
    }

    public function edit(Tag $tag, string $name): Tag
    {
        $tag->update([
            'name' => $name
        ]);

        return $tag;
    }

    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }

    public function attachTagsToArticle(
        array $tagNames,
        Article $article,
        User $user,
        TagRepositoryInterface $tagRepository
    ) {
        foreach ($tagNames as $name) {
            $tag = $tagRepository->getByName($user, $name);

            if (isset($tag)) {
                $this->attachToArticle($article, $tag);
            } else {
                $tag = $this->make($name, $user->id);
                $this->attachToArticle($article, $tag);
            }
        }
    }

    private function attachToArticle(Article $article, Tag $tag)
    {
        $article->tags()->attach($tag->id);
    }
}
