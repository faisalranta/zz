<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pvs extends Model{
	protected $table = 'pvs';
	protected $fillable = ['cleared_date','pv_date','pv_no','voucherType','cheque_no','cheque_date','post_dated','descr','sup_comments','maker_comments','username','status','pv_status','type','date','time','action','branch_id','trail_id','clearence','auto_clearence'];
	protected $primaryKey = 'id';
	public $timestamps = false;
}
