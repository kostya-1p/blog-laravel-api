<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Article;
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

    public function store(Article $article)
    {

    }
}
