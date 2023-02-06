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
use App\Services\CategoryService;
use App\Services\ImageService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private ArticleService $articleService,
        private ImageService $imageService,
        private CategoryService $categoryService,
        private TagService $tagService,
        private CategoryRepositoryInterface $categoryRepository,
        private TagRepositoryInterface $tagRepository
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
        $imageName = $this->imageService->generateImageName($request->file('cover_image'));
        $article = $this->articleService->make($request->validated(), $request->user()->id, $imageName);
        $this->imageService->saveCoverImage($article, $request->file('cover_image'), $imageName);

        $this->categoryService->attachCategoriesToArticle(
            $request->categories,
            $article,
            $request->user(),
            $this->categoryRepository
        );

        $this->tagService->attachTagsToArticle(
            $request->tags,
            $article,
            $request->user(),
            $this->tagRepository
        );

        return $article;
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
        $this->imageService->deleteCoverImage($article->cover_image_name, $article->id);
        $this->articleService->delete($article);
        return response('', 204);
    }
}
