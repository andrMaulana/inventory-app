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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->method() === 'POST') {
            return [
                'name' => 'required|unique:categories,name', // tambahkan ",name"
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
            ];
        }

        return [
            'name' => 'required|unique:categories,name,'. $this->category->id,
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ];
        }
}
