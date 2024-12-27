<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequisitionRequest extends FormRequest
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
            // 'rfq_number' => 'required|string|unique:rfqs,rfq_number',
            // 'request_date' => 'required|date',
            // 'allocation_date' => 'nullable|date',
            // 'title' => 'nullable|string',
            // 'products' => 'required|array|min:1',
        ];
    }
}
