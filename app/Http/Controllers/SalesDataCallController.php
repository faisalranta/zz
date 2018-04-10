<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use Config;
use App\Models\Customer;
class SalesDataCallController extends Controller
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
   	public function viewCashCustomerList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$customers = new Customer;
		$customers = $customers::where('status', '=', '1')
						->where('customer_type', '=', '2')->get();
		$counter = 1;
		foreach($customers as $row){
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
	
	public function viewCreditCustomerList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$customers = new Customer;
		$customers = $customers::where('status', '=', '1')
						->where('customer_type', '=', '3')->get();
		$counter = 1;
		foreach($customers as $row){
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
}
