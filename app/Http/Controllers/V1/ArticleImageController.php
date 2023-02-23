<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\Article;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleImageController extends Controller
{
    public function __construct(private ImageRepositoryInterface $imageRepository)
    {
    }

    public function index(Article $article, Request $request): AnonymousResourceCollection
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $images = $this->imageRepository->getByArticle($article);
        return ImageResource::collection($images);
    }
}
