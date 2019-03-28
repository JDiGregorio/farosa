<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;

class SaleRep extends Model
{
    use CrudTrait;

    protected $table = 'SalesRep';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['ID','Name'];
    // protected $hidden = [];
    // protected $dates = [];

    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/

    /*------------------------------------------------------------------------
    | RELATIONS
    |------------------------------------------------------------------------*/
	
	public function customers()
	{
		return $this->hasMany('App\Models\Customer');
	}
	
	public function transactionholds()
	{
		return $this->hasMany('App\Models\TransactionHold','SalesRepID');
	}
	
	public function users()
	{
		return $this->hasMany('App\User');
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
