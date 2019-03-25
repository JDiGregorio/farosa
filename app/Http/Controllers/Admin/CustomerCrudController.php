<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\CustomerRequest as StoreRequest;
use App\Http\Requests\CustomerRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

use App\Models\Customer;
use View;

class CustomerCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\Customer');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/clientes');
        $this->crud->setEntityNameStrings('cliente', 'clientes');
		
		$this->crud->removeButton('create');
		$this->crud->denyAccess(['update', 'delete','revisions']);
		$this->crud->addButtonFromView('line', 'view', 'view', 'end');
		
		$this->crud->addColumn([
			'name' => 'AccountNumber',
			'label' => 'Código', 
			'type' => 'text'
		]);
		
		$this->crud->addColumn([
			'name' => 'FirstName',
			'label' => 'Primer Nombre', 
			'type' => 'text',
		]);
    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud($request);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
	
	private function disponible($limite,$cuentaPendiente){		
		$resultado = $limite - $cuentaPendiente;
		return $resultado;
	}
	
	public function get_saldo($id)
	{
		$customer =  Customer::where([['id','=',$id]])->get();
		$limite = $customer->first()->CreditLimit;
		$cuenta = $customer->first()->AccountBalance;
		$disponible = $limite - $cuenta;
		return json_decode('[{"disponible":' . $disponible . ' }]');
	}
	
	public function get_customer($id)
	{
		$customer =  Customer::where([['id','=',$id]])->get();
		$disponible = $this->disponible($customer->first()->CreditLimit,$customer->first()->AccountBalance);
		
		$data = array(
			"customer"=>$customer,
			"disponible"=>$disponible,
		);
		
		return View::make('views.preview_customer')->with($data);
	}
	
	public function menu_usuarios(){
		return view('menu_usuarios');
	}
}
