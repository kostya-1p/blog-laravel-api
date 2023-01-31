<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    private TagRepositoryInterface $tagRepository;
    private TagService $tagService;

    public function __construct(TagRepositoryInterface $tagRepository, TagService $tagService)
    {
        $this->tagRepository = $tagRepository;
        $this->tagService = $tagService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $tags = $this->tagRepository->getUserTags($request->user());
        return TagResource::collection($tags);
    }

    public function store(StoreTagRequest $request): TagResource
    {
        $tag = $this->tagService->make($request->name, $request->user()->id);
        return new TagResource($tag);
    }

    public function show(Request $request, Tag $tag): TagResource
    {
        if ($tag->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag): TagResource
    {
        if ($tag->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $updatedTag = $this->tagService->edit($tag, $request->name);
        return new TagResource($updatedTag);
    }

    public function destroy(Request $request, Tag $tag)
    {
        if ($tag->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $this->tagService->delete($tag);
        return response('', 204);
    }
}
