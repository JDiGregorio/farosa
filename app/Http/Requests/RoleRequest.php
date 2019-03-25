<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
class RoleRequest extends FormRequest
{
 
    public function authorize()
    {
       return \Auth::check();
    }
    public function rules()
    {
        return [
            'name' => 'required',
        ]; 
    }
	
	 public function messages()
    {
        return [
			'name.required' => 'Necesita agregar el nombre de rol.',
        ];
    }
}