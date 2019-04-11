<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\Request;

class UserCrudController extends CrudController
{	
    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/user');
		
		$this->crud->removeButton('create');
		
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'username',
                'label' => "Usuario",
                'type'  => 'text',
            ],
        ]);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-12',
				],				
            ],
			[
                'name'  => 'username',
                'label' => "Usuario",
                'type'  => 'text',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-12',
				],				
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-12',
				],
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-12',
				],
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-12',
				],
            ],
			[
                'label' => "Vendedor",
				'type' => 'select2',
				'name' => 'SalesRep_id',
				'entity' => 'sales_rep',
				'attribute' => 'Name',
				'model' => "App\Models\SaleRep",
				'wrapperAttributes' => [
					'class' => 'form-group col-md-12',
				],
			],
			[
				'name' => 'digitar_precio',
				'label' => 'Digitar precio',
				'type' => 'radio',
				'options' => ["0" => "No puede digitar","1" => "Puede digitar"],
				'inline'      => true,
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
				],
			],
        ]);
		
		$this->crud->addField([
			'name' => 'tipo_user',
			'label' => 'Administrador',
			'type' => 'radio',
			'options' => ["0" => "No","1" => "Si"],
			'inline'      => true,
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		],'both');	
    }

	public function index()
	{
		$usuario = Backpack_auth()->user()->tipo_user;
		
		if($usuario != 1)
		{
			return redirect('/');
		}
		
		return parent::index();
	}
	
	public function search()
	{
		$usuario = Backpack_auth()->user()->tipo_user;
		
		if($usuario != 1)
		{
			return redirect('/');
		}
		
		return parent::search();
	}
	
	public function create()
	{
		$usuario = Backpack_auth()->user()->tipo_user;
		
		if($usuario != 1)
		{
			return redirect('/');
		}
		
		return parent::create();
	}
	
	public function edit($id)
	{
		$usuario = Backpack_auth()->user()->tipo_user;
		
		if($usuario != 1)
		{
			return redirect('/');
		}
		
		return parent::edit($id);
	}
	
	public function destroy($id)
	{
		$usuario = Backpack_auth()->user()->tipo_user;
		
		if($usuario != 1)
		{
			return redirect('/');
		}
		
		return parent::destroy($id);
	}

    public function store(StoreRequest $request)
    {
        $this->handlePasswordInput($request);
        return parent::storeCrud($request);
    }

    public function update(UpdateRequest $request)
    {
        $this->handlePasswordInput($request);
        return parent::updateCrud($request);
    }

    protected function handlePasswordInput(Request $request)
    {
        $request->request->remove('password_confirmation');

        if ($request->input('password')) {
            $request->request->set('password', bcrypt($request->input('password')));
        } else {
            $request->request->remove('password');
        }
    }
}
