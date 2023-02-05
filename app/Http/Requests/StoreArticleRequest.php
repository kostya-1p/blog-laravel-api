<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Rules\CategoryUniqueNameUserId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'text' => 'required|max:65535',
            'categories' => 'array',
            'tags' => 'array',
            'categories.*' => 'max:255|distinct',
            'tags.*' => 'max:255|distinct',
            'cover_image' => 'required|image',
        ];
    }
}
