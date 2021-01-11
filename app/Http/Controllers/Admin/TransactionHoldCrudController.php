<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\TransactionHoldRequest as StoreRequest;
use App\Http\Requests\TransactionHoldRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Auth;

use App\Models\Customer;
use App\Models\Tax;
use App\Models\TransactionHold;
use App\Models\TransactionHoldEntry;
use App\Authorizable;
use View;

class TransactionHoldCrudController extends CrudController
{
	use Authorizable;
	
	public function setup()
	{
		$user = backpack_user();
		$SalesRepID = $user->SalesRep_id;
		
		$select_filtro = !$user->tipo_user ? ['SalesRepID','=',$SalesRepID] : ['ID','!=',Null];

		if(!$user->tipo_user)
		{
			TransactionHold::setCampoFiltro('SalesRepID');
			TransactionHold::setValoresFiltro([$SalesRepID]);
		}
		
		$this->crud->setModel('App\Models\TransactionHold');
		$this->crud->setRoute(config('backpack.base.route_prefix') . '/pedidos');
		$this->crud->setEntityNameStrings('pedido', 'pedidos');
		$this->crud->disableResponsiveTable();
		
		$this->crud->removeButton('create');
		$this->crud->denyAccess(['update'],['revisions']);
		$this->crud->addButtonFromView('line', 'view', 'view', 'beginning');
		
		$this->crud->addColumn([
			'label' => "Cliente",
			'type' => "select",
			'key'  => 'name1',
			'name' => 'CustomerID', 
			'entity' => 'clientee', 
			'attribute' => "FirstName", 
			'model' => "App\Models\Customer",
		]);
		
		$this->crud->addColumn([
			'name' => 'HoldComment',
			'label' => "Comentario",
			'type' => "text",
		]);
		
		$this->crud->addField([
			'label' => "Cliente",
			'type' => 'select2_filtrable',
			'name' => 'CustomerID',
			'entity' => 'clientee',
			'attribute' => 'FirstName',
			'model' => "App\Models\Customer",
			'filter' => $select_filtro,
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);
		
		$this->crud->addField([
			'name' => 'toggle_pago',
			'label' => 'Forma de pago',
			'type' => 'toggle_pago',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);
		
		$this->crud->addField([
			'name' => 'credito_disponible',
			'label' => '',
			'type' => 'credito_disponible',
			'model' => "App\Models\TransactionHold",
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);
		
		$this->crud->addField([
			'name' => 'pedido_table',
			'label' => 'Productos',
			'type' => 'pedido_table',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);
		
		$this->crud->addField([
			'name' => 'total_pedido',
			'label' => 'Total',
			'type' => 'total_pedido2',
			'prefix' => 'L.',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);

		$this->crud->addField([
			'name' => 'detalle_pedido',
			'label' => 'Detalle de pedido',
			'type' => 'textarea',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);		
	}
	
	private function disponible($limite,$cuentaPendiente){		
		$dispo = $limite - $cuentaPendiente;
		$resultado = number_format($dispo, 2, '.', ',');
		return $resultado;
	}
	
	public function show($id)
	{
		$pedido = TransactionHold::where([['ID','=',$id]])->get();
		$ID_customer = $pedido->first()->CustomerID;
		$customer = Customer::where([['ID','=',$ID_customer]])->get();
		$cliente = $customer->first()->FirstName;
		$fecha = str_replace('-', ' / ', date("d-m-Y", strtotime($pedido->first()->TransactionTime)));
		
		$comentario = $pedido->first()->HoldComment;
		$partes = explode("/", $comentario);
		$tipo_pago = $partes[2];
		

		if(isset($partes[3])) {
			$detalle = $partes[3];
		} else {
			$detalle = "";
		}
		
		if($tipo_pago === "CREDITO"){
			$disponible = $this->disponible($customer->first()->CreditLimit,$customer->first()->AccountBalance);
		}else{
			$disponible = "0.00";
		}
		
		$productos = TransactionHoldEntry::where([['TransactionHoldID','=',$id]])->get();
		
		$total = 0;
		
		foreach($productos as $producto){
			$multiplicacion = $producto->QuantityPurchased * $producto->FullPrice;
			if($producto->Taxable == 1) {
				$tax = Tax::find($producto->TaxItemId);
				$multiplicacion = $producto->QuantityPurchased * ($producto->FullPrice * (1 + $tax->Percentage));
				$total += $multiplicacion;
			}else {
				$multiplicacion = $producto->QuantityPurchased * $producto->FullPrice;
				$total += $multiplicacion;
			} 
		}
		
		$data = array(
			"cliente" => $cliente,
			"fecha" => $fecha,
			"tipo_pago" => $tipo_pago,
			"detalle" => $detalle,
			"disponible" => $disponible,
			"productos" => $productos,
			"total" => $total,
		);
		
		return View::make('form_views.preview_pedido')->with($data);
	}
	
	public function edit($id)
	{
		return redirect('/admin/pedidos');
	}

	public function store(StoreRequest $request)
	{
		$redirect_location = parent::storeCrud($request);
		$this->insertProductos($this->crud->entry, $request->productos);
		return $redirect_location;
	}
	
	private function insertProductos($transactionhold, $entries)
	{
		$transactionhold->transactionholdentries()->delete();
		
		foreach($entries as $data){
			$transactionhold->transactionholdentries()->create([
				'TransactionHoldID' => $transactionhold->id,
				'Description' => $data['item_description'],
				'QuantityPurchased' => $data['item_qty'],
				'Price' => $data['item_price'],
				'FullPrice' => $data['item_price'],
				'Taxable' => False,
				'ItemID' => $data['item_id'],
				'SalesRepID' => $transactionhold->SalesRepID
			]);
		}
	}

	public function update(UpdateRequest $request)
	{
		$old_id = $request->ID;
		$old_transaction = TransactionHold::find($old_id);
		$old_transaction->transactionholdentries()->delete();
		$old_transaction->delete();

		$redirect_location = parent::storeCrud($request);
		$this->insertProductos($this->crud->entry, $request->productos);
		return $redirect_location;
	}
}
