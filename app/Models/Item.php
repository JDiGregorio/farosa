<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use CrudTrait;

    protected $table = 'Item';
    protected $primaryKey = 'ID';
    protected $fillable = ['ID','Description','ItemLookupCode','Price','PriceA','PriceB','PriceC','Quantity'];
    protected $visible = ['ID','Description','ItemLookupCode','Price','PriceA','PriceB','PriceC','Quantity'];
	public $timestamps = false;

    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/

    /*------------------------------------------------------------------------
    | RELATIONS
    |------------------------------------------------------------------------*/
	
	public function transactionholdentries()
	{
		return $this->hasMany('App\Models\TransactionHoldEntry','ItemID');
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
