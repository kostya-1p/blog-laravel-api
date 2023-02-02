<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private ArticleService $articleService,
        private CategoryRepositoryInterface $categoryRepository,
        private TagRepositoryInterface $tagRepository,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $userArticles = $this->articleRepository->getByUser($request->user());
        $userArticles = $this->articleService->getArticlesWithCoverImageURL($userArticles);

        return ArticleResource::collection($userArticles);
    }

    public function store(StoreArticleRequest $request)
    {
        //
    }

    public function show(Article $article)
    {
        //
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    public function destroy(Article $article)
    {
        //
    }
}
