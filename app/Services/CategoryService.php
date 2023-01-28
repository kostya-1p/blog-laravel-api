<?php

namespace App\Services;

use App\Models\Category;

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
}
