<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\ItemRequest as StoreRequest;
use App\Http\Requests\ItemRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

use App\Models\Item;
use View;

class ItemCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\Models\Item');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/productos');
        $this->crud->setEntityNameStrings('producto', 'productos');
		
		$this->crud->removeButton('create');
		$this->crud->denyAccess(['update', 'delete','revisions']);
		$this->crud->addButtonFromView('line', 'view', 'view', 'end');
		
		$this->crud->addColumn([
			'name' => 'ItemLookupCode',
			'label' => 'Código',
		]);
		
		$this->crud->addColumn([
			'name' => 'Description',
			'label' => 'Descripción',
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
	
	public function show($id)
	{
		$item =  Item::where([['id','=',$id]])->get();
		
		$data = array(
			"item"=>$item,
		);
		
		return View::make('form_views.preview_item')->with($data);
	}
	
	public function get_items()
	{
		$productos = Item::all();
		
		return $productos;
	}
}
