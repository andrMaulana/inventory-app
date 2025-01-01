<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if($this->method() === 'POST')
            return [
                'name' => 'required|unique:products',
                'image' => 'required|mimes:png,jpg,jpeg|max:2048',
                'category_id' => 'required',
                'supplier_id' => 'required',
                'description' => 'required',
                'unit' => 'required',
            ];
        elseif($this->method() === 'PUT')
            return [
                'name' => 'required','unique:products,name'.$this->product->id,
                'image' => 'mimes:png,jpg,jpeg|max:2048',
                'category_id' => 'required',
                'supplier_id' => 'required',
                'description' => 'required',
                'unit' => 'required',
            ];
    }
}
