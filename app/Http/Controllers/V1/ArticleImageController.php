<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Article;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleImageController extends Controller
{
    public function __construct(private ImageRepositoryInterface $imageRepository, private ImageService $imageService)
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

    public function store(Article $article, StoreImageRequest $request): ImageResource
    {
        if ($article->author_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $imageName = $this->imageService->generateImageName($request->image);
        $this->imageService->saveImage($article, $request->image, $imageName);
        $image = $this->imageService->make($imageName, $article->id);

        return new ImageResource($image);
    }
}
