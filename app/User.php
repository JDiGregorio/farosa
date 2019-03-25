<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Backpack\CRUD\CrudTrait; 
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
	use CrudTrait;
    use HasRoles;

    protected $fillable = ['name', 'email', 'password','digitar_precio','SalesRep_id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
	public $timestamps = false;
	
	public function sales_rep()
	{
		return $this->belongsTo('App\Models\SaleRep', 'SalesRep_id');
	}
}
