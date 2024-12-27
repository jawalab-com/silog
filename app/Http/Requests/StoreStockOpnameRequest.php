<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockOpnameRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'initial_stock' => 'required|integer|min:0',
            'final_stock' => 'required|integer|min:0',
            'date_opname' => 'required|date',
            'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
