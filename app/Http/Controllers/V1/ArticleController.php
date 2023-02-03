<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleIndexingResource;
use App\Http\Resources\ArticleShowingResource;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\ArticleService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface  $articleRepository,
        private ArticleService              $articleService,
        private ImageService                $imageService,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $userArticles = $this->articleRepository->getByUser($request->user());
        $userArticles = $this->articleService->getArticlesWithCoverImageURL($userArticles);

        return ArticleIndexingResource::collection($userArticles);
    }

    public function store(StoreArticleRequest $request)
    {
        //
    }

    public function show(Request $request, Article $article): ArticleShowingResource
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        return new ArticleShowingResource($article);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    public function destroy(Request $request, Article $article)
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $this->imageService->deleteCollection($article->images);
        $this->imageService->delete();
    }
}
