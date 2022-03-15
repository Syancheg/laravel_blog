<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts|max:100',
            'content' => 'required|string',
            'category_id' => 'required|integer',
            'main_image' => 'image|max:15360',
            'views' => 'integer',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
        ];
    }
}
