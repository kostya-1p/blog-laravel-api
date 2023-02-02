<?php

namespace App\Models;

use App\Services\ArticleService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Image extends Model
{
    use HasFactory;

    private ArticleService $articleService;

    protected $fillable = [
        'id',
        'name',
        'article_id',
        'created_at',
        'updated_at'
    ];

    protected function name(): Attribute
    {
        $this->articleService = App::make(ArticleService::class);

        return Attribute::make(
            get: fn($value) => $this->articleService->generateContentImageURL($this->article_id, $value),
        );
    }
}
