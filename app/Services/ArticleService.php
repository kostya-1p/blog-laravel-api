<?php

namespace App\Services;

class ArticleService
{
    private const STORAGE_FOLDER_NAME = 'storage';
    private const ARTICLES_FOLDER_NAME = 'articles_images';
    private const ARTICLE_ID_START_NAME = 'article_id_';

    public function generateCoverImageURL(int $articleId, string $imageName): string
    {
        return asset(self::STORAGE_FOLDER_NAME . '/' . self::ARTICLES_FOLDER_NAME . '/' .
            self::ARTICLE_ID_START_NAME . "{$articleId}/cover/{$imageName}");
    }
}
