<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use CrudTrait;

    protected $table = 'Customer';
    protected $primaryKey = 'ID';
    protected $fillable = ['ID','FirstName','AccountNumber','CustomText1','CustomText2','AccountBalance','CreditLimit','SalesRepID'];
    protected $visible = ['ID','FirstName'];
	public $timestamps = false;
	
    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/
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
		return $this->belongsTo('App\Models\SaleRep');
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
