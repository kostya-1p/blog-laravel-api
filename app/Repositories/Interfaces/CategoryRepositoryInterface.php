<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function getUserCategories(User $user): Collection;

    public function getByName(User $user, string $name): ?Category;
}
