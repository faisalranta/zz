<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fara extends Model{
	protected $table = 'fara';
	protected $fillable = ['pr_no','invoiceNo','grn_no','btNo','gfo_no','dlr_no','dlr_date','dc_date','main_ic_id','sub_ic_id','supp_id','qty','value','action','status','username','date','time','branch_id','acc_year_id','stockType','itemType'];
	protected $primaryKey = 'id';
	public $timestamps = false;
}
