<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestHiring extends Model{
	protected $table = 'RequestHiring';
	protected $fillable = ['RequestHiringNo','RequestHiringTitle','sub_department_id','job_type_id','designation_id','qualification_id','shift_type_id','RequestHiringGender','RequestHiringSalaryStart','RequestHiringSalaryEnd','RequestHiringAge','RequestHiringDescription','RequestHiringStatus','status','username','date','time'];
	protected $primaryKey = 'RequestHiringId';
	public $timestamps = false;
}
