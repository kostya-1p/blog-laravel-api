<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function make(string $name, int $articleId): Image
    {
        return Image::create([
            'name' => $name,
            'article_id' => $articleId,
        ]);
    }

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

    public function makeAndSaveImages(array $images, Article $article): void
    {
        foreach ($images as $image) {
            $imageName = $this->generateImageName($image);
            $this->saveImage($article, $image, $imageName);
            $this->make($imageName, $article->id);
        }
    }

    public function saveImage(Article $article, UploadedFile $file, string $fileName): void
    {
        $file->move(Storage::disk('articles_images')->path("/article_id_{$article->id}/"), $fileName);
    }

    public function saveCoverImage(Article $article, UploadedFile $file, string $fileName): void
    {
        $file->move(Storage::disk('articles_images')->path("/article_id_{$article->id}/cover/"), $fileName);
    }

    public function generateImageName(UploadedFile $file): string
    {
        return uniqid(more_entropy: true) . '.' . $file->extension();
    }
}
