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
            $this->delete($image);
        }
    }

    public function delete(Image $image)
    {
        $imageName = $image->getRawOriginal('name');
        $articleId = $image->article_id;

        Storage::disk('articles_images')->delete("/article_id_{$articleId}/{$imageName}");
        $image->delete();
    }

    public function deleteCoverImage(string $imageName, int $articleId)
    {
        Storage::disk('articles_images')->delete("/article_id_{$articleId}/cover/{$imageName}");
    }
}
