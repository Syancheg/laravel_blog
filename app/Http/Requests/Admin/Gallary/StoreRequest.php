<?php

namespace App\Http\Requests\Admin\Gallary;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'image' => 'nullable|integer',
            'images' => 'required|array|min:1',
            'images.*' => 'required|integer|distinct',
        ];
    }
}
