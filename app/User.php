<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Backpack\CRUD\CrudTrait; 
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
	use CrudTrait;

    protected $fillable = ['name', 'email', 'password','digitar_precio','SalesRep_id','tipo_user','username'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
	public $timestamps = false;
	
	public function sales_rep()
	{
		return $this->belongsTo('App\Models\SaleRep', 'SalesRep_id');
	}
	
	public static function boot()
    {
        parent::boot();
		
		self::creating(function($model)
		{
			$tipo_user = 1;
			$model->tipo_user = $tipo_user;
        });
	}
}
