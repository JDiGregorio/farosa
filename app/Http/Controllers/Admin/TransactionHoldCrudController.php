<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\TransactionHoldRequest as StoreRequest;
use App\Http\Requests\TransactionHoldRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Auth;

use App\Models\TransactionHold;
use App\Models\TransactionHoldEntry;

use App\Authorizable;

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
		$this->crud->denyAccess(['revisions']);
		
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
			'model' => "App\Models\TransactionHold",
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
