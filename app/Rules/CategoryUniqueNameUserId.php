<?php

namespace App\Rules;

use App\Models\User;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class CategoryUniqueNameUserId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private User $user, private CategoryRepositoryInterface $categoryRepository)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $userCategories = $this->categoryRepository->getUserCategories($this->user);

        foreach ($userCategories as $category) {
            if ($category->name === $value) {
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
        return 'This category name already exists!';
    }
}
