<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_name' => 'required',
            'category_image' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'category_name.required' => 'Please category nam de',
            'category_image.required' => 'Please category image de',
        ];
    }
}
