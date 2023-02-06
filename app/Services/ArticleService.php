<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    private const STORAGE_FOLDER_NAME = 'storage';
    private const ARTICLES_FOLDER_NAME = 'articles_images';
    private const ARTICLE_ID_START_NAME = 'article_id_';

    public function make(array $articleData, int $userId, string $imageName): Article
    {
        return Article::create([
            'title' => $articleData['title'],
            'text' => $articleData['text'],
            'author_id' => $userId,
            'cover_image_name' => $imageName,
        ]);
    }

    public function getArticlesWithCoverImageURL(Collection $articles): Collection
    {
        foreach ($articles as $article) {
            $imageUrl = $this->generateCoverImageURL($article->id, $article->cover_image_name);
            $article->cover_image_name = $imageUrl;
        }
        return $articles;
    }

    public function generateCoverImageURL(int $articleId, string $imageName): string
    {
        return asset(
            self::STORAGE_FOLDER_NAME . '/' . self::ARTICLES_FOLDER_NAME . '/' .
            self::ARTICLE_ID_START_NAME . "{$articleId}/cover/{$imageName}"
        );
    }

    public function generateContentImageURL(int $articleId, string $imageName): string
    {
        return asset(
            self::STORAGE_FOLDER_NAME . '/' . self::ARTICLES_FOLDER_NAME . '/' .
            self::ARTICLE_ID_START_NAME . "{$articleId}/{$imageName}"
        );
    }

    public function delete(Article $article)
    {
        $article->categories()->detach();
        $article->tags()->detach();
        $article->delete();
    }
}
