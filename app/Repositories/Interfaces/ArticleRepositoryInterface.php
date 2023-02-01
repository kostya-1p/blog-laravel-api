<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
    public function getByUser(User $user): Collection;
}
