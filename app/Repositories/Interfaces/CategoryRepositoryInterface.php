<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function getUserCategories(User $user): Collection;
}
