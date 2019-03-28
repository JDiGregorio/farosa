<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use CrudTrait;

    protected $table = 'Customer';
    protected $primaryKey = 'ID';
    protected $fillable = ['ID','FirstName','AccountNumber','CustomText1','CustomText2','AccountBalance','CreditLimit','SalesRepID'];
    protected $visible = ['ID','FirstName', 'CustomText2'];
	public $timestamps = false;
	protected static  $_campoFiltro;
	protected static  $_valoresFiltro;
	
    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/
	
	public static function setCampoFiltro($campo)
	{
		static::$_campoFiltro = $campo;
	}
	
	public static function setValoresFiltro($listaValores)
	{
		static::$_valoresFiltro = $listaValores;
	}
	
	public static function boot()
    {
		parent::boot();
		
		if(isset(static::$_valoresFiltro))
		{
			static::addGlobalScope('accessiblex' . static::$_campoFiltro, function (Builder $builder){
				$builder->whereIn(static::$_campoFiltro, static::$_valoresFiltro);
			});
		}
	}
	
	public function saldo()
	{
		$customer =  $this;
		
		$limite = $customer->CreditLimit;
		$cuenta = $customer->AccountBalance;
		
		$disponible = $limite - $cuenta;
		
		return $disponible;
	}
    /*------------------------------------------------------------------------
    | RELATIONS
    |------------------------------------------------------------------------*/
	
	public function salerep()
	{
		return $this->belongsTo('App\Models\SaleRep','SalesRepID');
	}
	
	public function transactionholds()
	{
		return $this->hasMany('App\Models\TransactionHold','CustomerID');
	}
	
    /*------------------------------------------------------------------------
    | SCOPES
    |------------------------------------------------------------------------*/

    /*------------------------------------------------------------------------
    | ACCESORS
    |------------------------------------------------------------------------*/

    /*------------------------------------------------------------------------
    | MUTATORS
    |------------------------------------------------------------------------*/
}
