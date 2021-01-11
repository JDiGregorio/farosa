<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'Tax';
    protected $primaryKey = 'ID';
    protected $fillable = ['ID','Description','Percentage','Price','Code'];
	public $timestamps = false;
}
