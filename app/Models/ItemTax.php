<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTax extends Model
{
    protected $table = 'ItemTax';
    protected $primaryKey = 'ID';
    protected $fillable = ['HQID','Description','TaxID01','TaxID02', 'TaxID02', 'TaxID03', 'TaxID04', 'TaxID05', 'TaxID06', 'TaxID07', 'TaxID08', 'TaxID09', 'TaxID10'];
	public $timestamps = false;
}
