<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private ArticleService $articleService
    ) {
    }

    public function index(Request $request)
    {
        $userArticles = $this->articleRepository->getByUser($request->user());

        $coverImageURL = $this->articleService->generateCoverImageURL($userArticles->get(0)->id, $userArticles->get(0)->cover_image_name);
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
