<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryService
{
    public function make(string $name, int $userId): Category
    {
        return Category::create([
            'name' => $name,
            'user_id' => $userId,
        ]);
    }

    public function edit(Category $category, string $name): Category
    {
        $category->update([
            'name' => $name
        ]);

        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function attachCategoriesToArticle(
        array $categoryNames,
        Article $article,
        User $user,
        CategoryRepositoryInterface $categoryRepository
    ) {
        foreach ($categoryNames as $name) {
            $category = $categoryRepository->getByName($user, $name);

            if (isset($category)) {
                $this->attachToArticle($article, $category);
            } else {
                $category = $this->make($name, $user->id);
                $this->attachToArticle($article, $category);
            }
        }
    }

    private function attachToArticle(Article $article, Category $category)
    {
        $article->categories()->attach($category->id);
    }

    public function detachCategoriesFromArticle(Article $article)
    {
        $article->categories()->detach();
    }

    public function detachFromArticle(Article $article, Category $category)
    {
        $article->categories()->detach($category->id);
    }
}
