<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\TransactionHoldRequest as StoreRequest;
use App\Http\Requests\TransactionHoldRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Auth;

use App\Models\TransactionHold;
use App\Models\TransactionHoldEntry;

class TransactionHoldCrudController extends CrudController
{
	public function setup()
	{
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
		
		$this->crud->addField([
			'label' => "Cliente",
			'type' => 'select2_editado',
			'name' => 'CustomerID',
			'entity' => 'clientee',
			'attribute' => 'FirstName',
			'model' => "App\Models\Customer",
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
		
		// $this->crud->addField([
			// 'label' => "Vendedor",
			// 'type' => 'select2_editado',
			// 'name' => 'SalesRepID',
			// 'entity' => 'salerep',
			// 'attribute' => 'Name',
			// 'model' => "App\Models\SaleRep",
			// 'wrapperAttributes' => [
				// 'class' => 'form-group col-md-12',
			// ],
		// ]);
		
		// $this->crud->addField([
			// 'name' => 'TransactionTime',
			// 'label' => 'Hora',
			// 'type' => 'datetime_picker',
			// 'datetime_picker_options' => [
				// 'format' => 'YYYY-MM-DD HH:mm:ss',
				// 'language' => 'es'
			// ],
			// 'wrapperAttributes' => [
				// 'class' => 'form-group col-md-12',
			// ],
		// ]);
		
		// $this->crud->addField([
			// 'name' => 'HoldComment',
			// 'label' => 'Comentario',
			// 'type' => 'textarea',
			// 'attributes' => [
				// 'placeholder' => 'Agregue el comentario',
				// 'style' => 'text-align:justify;resize:vertical;',
				// 'rows' => '5',
			// ],
			// 'wrapperAttributes' => [
				// 'class' => 'form-group col-md-12',
			// ],
		// ]);	
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
		$redirect_location = parent::updateCrud($request);
		$this->insertProductos($this->crud->entry, $request->productos);
		return $redirect_location;
	}
}
