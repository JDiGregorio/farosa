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
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['ID','Description','ItemLookupCode','Price','PriceA','PriceB','PriceC'];
    protected $visible = ['ID','Description','ItemLookupCode','Price','PriceA','PriceB','PriceC'];
    // protected $hidden = [];
    // protected $dates = [];
	protected $guard_name = 'web';

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
