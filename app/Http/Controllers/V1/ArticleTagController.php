<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTagToArticleRequest;
use App\Http\Resources\ArticleShowingResource;
use App\Http\Resources\TagResource;
use App\Models\Article;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleTagController extends Controller
{
    public function __construct(
        private TagRepositoryInterface $tagRepository,
        private TagService $tagService
    ) {
    }

    public function index(Article $article, Request $request): AnonymousResourceCollection
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $tags = $this->tagRepository->getByArticle($article);
        return TagResource::collection($tags);
    }

    public function store(Article $article, AddTagToArticleRequest $request): ArticleShowingResource
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $this->tagService->attachTagsToArticle([$request->name], $article, $request->user(), $this->tagRepository);
        return new ArticleShowingResource($article);
    }

    public function destroy(Article $article, Tag $tag, Request $request)
    {
        $tags = $this->tagRepository->getByArticle($article);
        if ($article->author_id !== $request->user()->id || !$tags->contains($tag)) {
            return abort(403, 'Unauthorized action.');
        }

        $this->tagService->detachFromArticle($article, $tag);
        return response('', 204);
    }
}
