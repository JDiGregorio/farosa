<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionHoldEntry extends Model
{
    use CrudTrait;

    protected $table = 'TransactionHoldEntry';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['ID','TransactionHoldID','Description','QuantityPurchased','Price','FullPrice','Taxable','ItemID',
						   'EntryKey','StoreID','RecallID','QuantityOnOrder','QuantityRTD','QuantityReserved','PriceSource',
						   'Comment','DetailID','SalesRepID','SerialNumber1','SerialNumber2','SerialNumber3','VoucherNumber',
						   'VoucherExpirationDate','DBTimeStamp','DiscountReasonCodeID','ReturnReasonCodeID','TaxChangeReasonCodeID',
						   'ItemTaxID','ComponentQuantityReserved','TransactionTime','IsAddMoney','VoucherID'];
    // protected $hidden = [];
    protected $visible = ['ID','TransactionHoldID','Description','QuantityPurchased','Price','ItemID','SalesRepID','TransactionTime'];
	
    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/
	
	public static function boot()
    {
		parent::boot();
		
		if(isset(static::$_valoresFiltro))
		{
			static::addGlobalScope('accessiblex' . static::$_campoFiltro, function (Builder $builder){
				$builder->whereIn(static::$_campoFiltro, static::$_valoresFiltro);
			});
		}
		
        self::creating(function($model)
		{
			$default_expiration_date = Carbon::create(1899, 12, 30)->toDateTimeLocalString();
			$default_transaction_date = Carbon::now();
			$default_transaction_date_string = $default_transaction_date->toDateTimeLocalString() . "." . substr($default_transaction_date->format("u"),0,3);
			
			$model->VoucherExpirationDate =$default_expiration_date;
			$model->TransactionTime = str_replace(" ", "T", $model->transactionhold()->get()->first()->TransactionTime);
        });
	}
	
    /*------------------------------------------------------------------------
    | RELATIONS
    |------------------------------------------------------------------------*/
	
	public function transactionhold()
	{
		return $this->belongsTo('App\Models\TransactionHold','TransactionHoldID');
	}
	
	public function item()
	{
		return $this->belongsTo('App\Models\Item','ItemID');
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
