<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Backpack\PermissionManager\app\Http\Controllers\PermissionCrudController as CrudController;
use Backpack\PermissionManager\app\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Auth;

class PermissionCrudController extends CrudController
{
    public function getTiposPermisos()
	{
		return array( "add", "delete", "edit", "view", "search");
	}
	
	public function crear_permisos() 
	{
		$tipoPermisos = $this->getTiposPermisos();
		$almacenados = array();
		$modelsStored = Permission::get()->pluck('name')->toArray();
		
		$modelFiles = glob(base_path().'/app/Models/*.php');
		
		foreach ($modelFiles as $filename)
		{			
			$pathinfo = pathinfo($filename);
			
			$modelBaseName = strtolower( str_replace('_','-', $pathinfo['filename'] ) );
			
			foreach ( $tipoPermisos as $permiso ) 
			{
				$modelName = $permiso.'-'.$modelBaseName;
				
				if ( in_array( $modelName, $modelsStored) == false )
				{
					$permiso = Permission::create([
						  "name"   => $modelName
					   ]);
					   
					 if ( $permiso ) 
					 {
						 array_push($almacenados, $modelName);
					 }
				}
			}
		}
		
		app(PermissionRegistrar::class)->forgetCachedPermissions();
		return json_encode($almacenados);
	}
}
