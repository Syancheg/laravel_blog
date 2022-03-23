<?php

namespace App\Http\Requests\Admin\Entity\Dog;

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
            'name' => 'required|string|max:255',
            'gender' => 'required|integer',
            'text' => 'nullable|string',
            'image' => 'nullable|integer',
            'birthday' => 'required|date|date_format:"Y-m-d"',
            'active' => 'nullable|string',
            'father' => 'nullable|integer',
            'mother' => 'nullable|integer',
            'achievements' => 'nullable|array',
            'achievements.date' => 'nullable|date|date_format:"Y-m-d"',
            'achievements.name' => 'nullable|string|max:255',
        ];
    }
}
