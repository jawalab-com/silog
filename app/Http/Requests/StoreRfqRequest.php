<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRfqRequest extends FormRequest
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
			'rfq_number' => 'required|string|unique:rfqs,rfq_number',
			'request_date' => 'required|date',
			'allocation_date' => 'nullable|date|after_or_equal:today',
			'title' => 'required|string',
			'products' => 'required|array|min:1',
		];
	}

	public function messages()
	{
		return [
			'title.required' => 'Perihal harus diisi', // Custom message for the title field
			'allocation_date.after_or_equal' => 'Tanggal Peruntukan harus hari ini atau setelahnya.',
		];
	}
}
