<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
                'name' => 'required|unique:suppliers',
                'telp' => 'required|numeric|digits_between:1,12',
                'address' => 'required|string',
            ];
        elseif($this->method() === 'PUT')
            return [
                'name' => 'required|unique:suppliers,name,'. $this->supplier->id,
                'telp' => 'required|numeric|digits_between:1,12',
                'address' => 'required|string',
            ];
    }
}
