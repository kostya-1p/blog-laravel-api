<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function deleteCollection(Collection $images)
    {
        foreach ($images as $image) {
            $this->delete($image, false);
        }
    }

    public function delete(Image $image, bool $isCover)
    {
        $imageName = $image->getRawOriginal('name');
        $articleId = $image->article_id;
        $cover = $isCover ? 'cover/' : '';

        Storage::disk('articles_images')->delete("/article_id_{$articleId}/{$cover}{$imageName}");
        $image->delete();
    }
}
