<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subitem extends Model{
	protected $table = 'subitem';
	protected $fillable = ['supplier_id','sub_ic','main_ic_id','acc_id','department_id','pack_size','kit_amount','tax_able','sales_tax_rate','time','date','action','username','status','trail_id','branch_id','type','no_test','uom','saleOutUnitQuantityPrice','allowDiscountUnitQuantity','completeBoxPrice','completeBoxDiscount','allowTestingQuantity','inventoryStockEveryTime','totalQuantityinOnePack','stockType','itemType'];
	protected $primaryKey = 'id';
	public $timestamps = false;
}
