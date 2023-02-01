<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Tag;
use App\Models\TagArticle;
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
        return $user->tags();
    }

    public function getTagsForArticleCollection(Collection $articles): Collection
    {
        $tags = collect();
        foreach ($articles as $article) {
            $articleTags = $this->getArticleTags($article);
            $tags->push($articleTags);
        }
        return $tags;
    }

    public function getArticleTags(Article $article): Collection
    {
        $tagArticleIds = TagArticle::where('article_id', $article->id)->get();
        $tags = collect();

        foreach ($tagArticleIds as $tagArticle) {
            $tag = Tag::find($tagArticle->tag_id);
            $tags->push($tag);
        }
        return $tags;
    }
}
