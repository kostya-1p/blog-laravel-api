<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryToArticleRequest;
use App\Http\Resources\ArticleShowingResource;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleCategoryController extends Controller
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryService $categoryService
    ) {
    }

    public function index(Article $article, Request $request): AnonymousResourceCollection
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $categories = $this->categoryRepository->getByArticle($article);
        return CategoryResource::collection($categories);
    }

    public function store(Article $article, AddCategoryToArticleRequest $request): ArticleShowingResource
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $categories = $this->categoryRepository->getByArticle($article);
        foreach ($categories as $category) {
            if ($category->name === $request->name) {
                return abort(400, 'Category already attached');
            }
        }

        $this->categoryService->attachCategoriesToArticle(
            [$request->name],
            $article,
            $request->user(),
            $this->categoryRepository
        );

        return new ArticleShowingResource($article);
    }

    public function destroy(Article $article, Category $category, Request $request)
    {
        $categories = $this->categoryRepository->getByArticle($article);
        if ($article->author_id !== $request->user()->id || !$categories->contains($category)) {
            return abort(403, 'Unauthorized action.');
        }

        $this->categoryService->detachFromArticle($article, $category);
        return response('', 204);
    }
}
