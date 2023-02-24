<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function getUserCategories(User $user): Collection
    {
        return $user->categories;
    }

    public function getByName(User $user, string $name): ?Category
    {
        $categories = $this->getUserCategories($user);

        foreach ($categories as $category) {
            if (strtolower($category->name) === strtolower($name)) {
                return $category;
            }
        }
        return null;
    }

    public function getByArticle(Article $article): Collection
    {
        return $article->categories;
    }
}
