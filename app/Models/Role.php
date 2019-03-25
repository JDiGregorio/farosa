<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Models\Role as OriginalRole;
use Illuminate\Support\Facades\Auth;

class Role extends OriginalRole
{
    use CrudTrait;
	
    protected $fillable = ['name', 'guard_name'];
	public $timestamps = false;
	protected $guard_name = 'web';
	
	public static function boot()
    {
		parent::boot();
    }
}