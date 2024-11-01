<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
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
            'submission_number' => 'required|string',
            'order_date' => 'required|date',
            'details' => 'nullable|array|min:1',
            'details.*.product_id' => 'required|uuid',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit' => 'nullable|string',
        ];
    }
}
