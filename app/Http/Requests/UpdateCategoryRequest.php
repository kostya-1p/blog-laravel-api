<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Rules\CategoryUniqueNameUserId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                new CategoryUniqueNameUserId($this->user(), App::make(CategoryRepositoryInterface::class))
            ]
        ];
    }
}
