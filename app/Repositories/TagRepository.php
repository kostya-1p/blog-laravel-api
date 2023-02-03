<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

class TagRepository implements Interfaces\TagRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tag::all();
    }

    public function getUserTags(User $user): Collection
    {
        return $user->tags;
    }
}
