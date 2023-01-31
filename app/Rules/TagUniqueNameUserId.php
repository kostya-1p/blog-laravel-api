<?php

namespace App\Rules;

use App\Models\User;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class TagUniqueNameUserId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private User $user, private TagRepositoryInterface $tagRepository)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $userTags = $this->tagRepository->getUserTags($this->user);

        foreach ($userTags as $tag) {
            if (strtolower($tag->name) === strtolower($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This tag name already exists!';
    }
}
