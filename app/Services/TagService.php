<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function make(string $name, int $userId): Tag
    {
        return Tag::create([
            'name' => $name,
            'user_id' => $userId,
        ]);
    }

    public function edit(Tag $tag, string $name): Tag
    {
        $tag->update([
            'name' => $name
        ]);

        return $tag;
    }

    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }
}
