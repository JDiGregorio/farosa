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
			'name' => 'credito_disponible',
			'label' => '',
			'type' => 'credito_disponible',
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
		// $this->insertReferencias($this->crud->entry, $request->aval);
        return $redirect_location;
    }
	
	private function insertReferencias($transactionhold, $entries)
	{
		foreach($entries as $data){
			$transactionhold->transactionholdentries()->create([
				'TransactionHoldID' => $data['TransactionHoldID'],
				'Description' => $data['Description'],
				'QuantityPurchased' => $data['QuantityPurchased'],
				'Price' => $data['Price'],
				'FullPrice' => $data['FullPrice'],
				'Taxable' => $data['Taxable'],
				'ItemID' => $data['ItemID'],
			]);
		}
	}

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
}
