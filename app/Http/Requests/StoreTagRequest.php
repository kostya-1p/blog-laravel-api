<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Rules\TagUniqueNameUserId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class StoreTagRequest extends FormRequest
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
            'name' => [
                'required',
                new TagUniqueNameUserId($this->user(), App::make(TagRepositoryInterface::class))
            ]
        ];
    }
}
