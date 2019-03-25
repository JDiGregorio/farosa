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
	protected $guard_name = 'web';
	
    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/

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
