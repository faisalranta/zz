<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model{
	protected $table = 'deduction';
	protected $fillable = ['emp_id','ps_no','department_id','month','year','deduction_type','deduction_amount','status','username','date','time'];
	protected $primaryKey = 'id';
	public $timestamps = false;
}
