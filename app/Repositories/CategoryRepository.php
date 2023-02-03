<?php

namespace App\Repositories;

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
}
