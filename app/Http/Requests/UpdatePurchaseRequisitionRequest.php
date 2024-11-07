<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequisitionRequest extends FormRequest
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
            // // 'suppliers' => 'required|json',
            // 'request_date' => 'required|date',
            // 'allocation_date' => 'nullable|date',
            // 'title' => 'nullable|string',
            // 'verified' => 'nullable|boolean',
            // // 'status' => 'required|string',
            // 'comment' => 'nullable|string',
            // 'suppliers' => 'nullable|array',
            // 'products' => 'required|array|min:1',
        ];
    }
}
