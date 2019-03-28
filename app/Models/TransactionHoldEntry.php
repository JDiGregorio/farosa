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
    protected $visible = ['ID','TransactionHoldID','Description','QuantityPurchased','Price','ItemID','SalesRepID'];
	
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
			// $default_expiration_date = Carbon::create(1899, 12, 30);
			// $default_transaction_date = date('Y-m-d H:i:s.00');
			
			// $model->VoucherExpirationDate = $default_expiration_date;			
			//$model->Transactiontime = $default_transaction_date;			
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
