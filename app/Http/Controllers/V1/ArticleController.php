<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private ArticleService $articleService,
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function index(Request $request)
    {
        $userArticles = $this->articleRepository->getByUser($request->user());
        $categories = $this->categoryRepository->getCategoriesForArticleCollection($userArticles);

        $userArticles = $this->articleService->getArticlesWithCoverImageURL($userArticles);
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
