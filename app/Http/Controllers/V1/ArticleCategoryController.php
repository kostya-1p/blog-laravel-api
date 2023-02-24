<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleCategoryController extends Controller
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function index(Article $article, Request $request): AnonymousResourceCollection
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $categories = $this->categoryRepository->getByArticle($article);
        return CategoryResource::collection($categories);
    }

    public function store(Article $article)
    {

    }
}
