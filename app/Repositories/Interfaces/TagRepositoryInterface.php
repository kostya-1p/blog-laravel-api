<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface
{
    public function getAll(): Collection;

    public function getUserTags(User $user): Collection;
}
