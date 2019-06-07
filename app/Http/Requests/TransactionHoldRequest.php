<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class TransactionHoldRequest extends FormRequest
{
	public function authorize()
	{
		return backpack_auth()->check();
	}

	public function rules()
	{
		return [
			'productos' => 'required',
			'CustomerID' => 'required',
			'toggle_pago' => 'required',
		];
	}

	public function attributes()
	{
		return [];
	}

	public function messages()
	{
		return [
			'productos.required' => 'Necesita seleccionar al menos un producto.',
			'CustomerID.required' => 'Necesita seleccionar el cliente.',
			'toggle_pago.required' => 'Necesita seleccionar la forma de pago.',
		];
	}
}
