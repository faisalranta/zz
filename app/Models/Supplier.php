<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model{
	protected $table = 'supplier';
	protected $fillable = ['acc_id','type','name','address','country','province','city','contact','status','action','username','date','time','branch_id'];
	protected $primaryKey = 'id';
	public $timestamps = false;
}
