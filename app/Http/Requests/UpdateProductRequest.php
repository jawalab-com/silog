<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        return [
            'product_name' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'tag' => 'nullable|string',
            'product_description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'minimum_quantity' => 'required|integer|min:0',
            'verified' => 'required|boolean',
            'unit_id' => 'required|exists:units,id',
            'unit_conversions' => 'nullable|array',
        ];
    }
}
