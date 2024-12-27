<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRfqRequest extends FormRequest
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
			// 'suppliers' => 'required|json',
			'request_date' => 'nullable|date',
			'allocation_date' => 'nullable|date',
			'title' => 'required|string',
			'verified' => 'nullable|boolean',
			// 'status' => 'required|string',
			'comment' => 'nullable|string',
			'suppliers' => 'nullable|array',
			// 'suppliers.*.tag' => 'nullable|string',
			// 'suppliers.*.supplier_id' => 'nullable|uuid',
			// 'suppliers.*.discount' => 'nullable|numeric|min:0',
			// 'suppliers.*.tax' => 'nullable|numeric|min:0',
			// 'suppliers.*.file_proof_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
			// 'suppliers.*.file_receipt_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
			'products' => 'nullable|array|min:1',
			'status' => 'nullable|string',
		];
	}

	public function messages()
	{
		return [
			'title.required' => 'Perihal harus diisi', // Custom message for the title field
		];
	}
}
