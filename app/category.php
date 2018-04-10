<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
	
    protected $table = 'category';
	protected $fillable = ['name'];
	protected $primaryKey = 'id';
	public $timestamps = true;
}
