<?php
namespace App;
use Auth;
trait Authorizable
{
    private $abilities = [
        'index' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete'
    ];
    public function callAction($method, $parameters)
    {
        if($ability = $this->getAbility($method)){
			
			$user = Auth::user();
			
			if( !$user->hasPermissionTo($ability)){ 
				abort(403);
			}
        }
        return parent::callAction($method, $parameters);
    }
    public function getAbility($method)
    {
        $routeName = explode('.', \Request::route()->getName());
        $action = array_get($this->getAbilities(), $method);
        return $action ? $action . '-' . $routeName[1] : null;
    }
    private function getAbilities()
    {
        return $this->abilities;
    }
    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}