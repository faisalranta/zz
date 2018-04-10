<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use Config;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Subitem;
class PurchaseDataCallController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   	public function viewSupplierList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$suppliers = new Supplier;
		$suppliers = $suppliers::where('status', '=', 'active')->get();
		$counter = 1;
		foreach($suppliers as $row){
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td><?php echo $row['name'];?></td>
			<td class="text-center"><?php echo $row['contact'];?></td>
			<td><?php echo $row['email'];?></td>
			<td></td>
		</tr>
	<?php
		}
	}
	
	public function viewCategoryList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$categories = new Category;
		$categories = $categories::where('status', '=', 'active')->get();
		$counter = 1;
		foreach($categories as $row){
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td><?php echo $row['main_ic'];?></td>
			<td></td>
		</tr>
	<?php
		}
	}
	
	public function viewSubItemList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$subitems = new Subitem;
		$subitems = $subitems::where('status', '=', 'active')->get();
		$counter = 1;
		foreach($subitems as $row){
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td><?php echo DB::selectOne('SELECT `main_ic`  FROM `category` WHERE `id` = '.$row['main_ic_id'].'')->main_ic;?></td>
			<td><?php echo $row['sub_ic'];?></td>
			<td></td>
		</tr>
	<?php
		}
	}
	
	
}
