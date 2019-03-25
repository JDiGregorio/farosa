<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;

class TransactionHold extends Model
{
    use CrudTrait;

    protected $table = 'TransactionHold';
    protected $primaryKey = 'ID';
    public $timestamps = false;
	protected $appends = ['transactionholdentries'];
    protected $fillable = ['StoreID','TransactionType','HoldComment','RecallID','Comment','PriceLevel',					   
						   'DiscountMethod','DiscountPercent','Taxable','CustomerID','DeltaDeposit',
						   'DepositOverride','DepositPrevious','PaymentsPrevious','TaxPrevious','SalesRepID',
						   'ShipToID','TransactionTime','ExpirationOrDueDate','ReturnMode','ReferenceNumber',
						   'ShippingChargePurchased','ShippingChargeOverride','ShippingServiceID',
						   'ShippingTrackingNumber','ShippingNotes','DBTimeStamp','ReasonCodeID',
						   'ExchangeID','ChannelType','DefaultDiscountReasonCodeID',
						   'DefaultReturnReasonCodeID','DefaultTaxChangeReasonCodeID','BatchNumber'];
    protected $hidden = ['DBTimeStamp'];
    // protected $dates = [];
	protected $guard_name = 'web';

    /*------------------------------------------------------------------------
    | FUNCTIONS
    |------------------------------------------------------------------------*/
	
	public static function boot()
    {
		parent::boot();
		
        self::creating(function($model)
		{
			$default_cero = 0;
			$default_uno = 1;
			$default_dos = 2;
			$default_tres = 3;
			$default_verdadero = 1;
			$default_falso = 0;
			$default_vacio = "";
			
			$model->StoreID = $default_cero;
			$model->TransactionType = $default_uno;
			$model->RecallID = $default_cero;
			$model->Comment = $default_vacio;
			$model->PriceLevel = $default_cero;		
			$model->DiscountMethod = $default_dos;		
			$model->DiscountPercent = $default_cero;		
			$model->Taxable = $default_verdadero;		
			$model->DeltaDeposit = $default_cero;		
			$model->DepositOverride = $default_falso;		
			$model->DepositPrevious = $default_cero;		
			$model->PaymentsPrevious = $default_cero;		
			$model->TaxPrevious = $default_cero;		
			$model->ShipToID = $default_cero;		
			$model->ExpirationOrDueDate = $default_cero;		
			$model->ReturnMode = $default_falso;		
			$model->ReferenceNumber = $default_vacio;		
			$model->ShippingChargePurchased = $default_cero;		
			$model->ShippingChargeOverride = $default_falso;		
			$model->ShippingServiceID = $default_cero;		
			$model->ShippingTrackingNumber = $default_vacio;		
			$model->ShippingNotes = $default_vacio;		
			$model->ReasonCodeID = $default_cero;		
			$model->ExchangeID = $default_cero;		
			$model->ChannelType = $default_cero;		
			$model->DefaultDiscountReasonCodeID = $default_cero;		
			$model->DefaultReturnReasonCodeID = $default_cero;		
			$model->DefaultTaxChangeReasonCodeID = $default_cero;		
			$model->BatchNumber = $default_tres;		
        });
		
		
		self::updating(function($model)
		{
			$default_cero = 0;
			$default_uno = 1;
			$default_dos = 2;
			$default_tres = 3;
			$default_verdadero = 1;
			$default_falso = 0;
			$default_vacio = "";

			$model->StoreID = $default_cero;
			$model->TransactionType = $default_uno;
			$model->RecallID = $default_cero;
			$model->PriceLevel = $default_cero;		
			$model->DiscountMethod = $default_dos;		
			$model->DiscountPercent = $default_cero;		
			$model->Taxable = $default_verdadero;		
			$model->DeltaDeposit = $default_cero;		
			$model->DepositOverride = $default_falso;		
			$model->DepositPrevious = $default_cero;		
			$model->PaymentsPrevious = $default_cero;		
			$model->TaxPrevious = $default_cero;		
			$model->ShipToID = $default_cero;		
			$model->ExpirationOrDueDate = $default_cero;		
			$model->ReturnMode = $default_falso;		
			$model->ShippingChargePurchased = $default_cero;		
			$model->ShippingChargeOverride = $default_falso;		
			$model->ShippingServiceID = $default_cero;		
			$model->ReasonCodeID = $default_cero;		
			$model->ExchangeID = $default_cero;		
			$model->ChannelType = $default_cero;		
			$model->DefaultDiscountReasonCodeID = $default_cero;		
			$model->DefaultReturnReasonCodeID = $default_cero;		
			$model->DefaultTaxChangeReasonCodeID = $default_cero;		
			$model->BatchNumber = $default_tres;
        });
		
		self::deleting(function($model)
		{
            //$model->transactionholdentries()->delete();
        });
    }
	
    /*------------------------------------------------------------------------
    | RELATIONS
    |------------------------------------------------------------------------*/
	
	public function salerep()
	{
		return $this->belongsTo('App\Models\SaleRep','SalesRepID');
	}
	
	public function transactionholdentries()
	{
		return $this->hasMany('App\Models\TransactionHoldEntry');
	}
	
	public function clientee()
	{
		return $this->belongsTo('App\Models\Customer','CustomerID');
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
