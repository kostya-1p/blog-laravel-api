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
}
