<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use Config;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\Employee;
class SelectListLoadAjaxController extends Controller
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
	 
	 public function stateLoadDependentCountryId(){
	 	$country_id = $_GET['id'];
	 	$states = new States;
		$states = $states::where('status', '=', 1)
				->where('country_id','=',$country_id)->get();
	 	//$result = $this->db->where("country_id",$id)->get("demo_cities")->result();
	?>
		<option value="">Select State</option>
	<?php
		foreach($states as $row){
	?>
		<option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
	<?php
		}
	 }
	 
	 public function cityLoadDependentStateId(){
	 	$state_id = $_GET['id'];
	 	$cities = new Cities;
		$cities = $cities::where('status', '=', 1)
				->where('state_id','=',$state_id)->get();
	 	//$result = $this->db->where("country_id",$id)->get("demo_cities")->result();
	?>
		<option value="">Select City</option>
	<?php	
		foreach($cities as $row){
	?>
		<option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
	<?php
		 }
	 }
	 
	 public function employeeLoadDependentDepartmentID(){
	 	Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$department_id = $_GET['id'];
	 	$employees = new Employee;
		$employees = $employees::where('status', '=', 1)
				->where('emp_department_id','=',$department_id)->get();
	 	//$result = $this->db->where("country_id",$id)->get("demo_cities")->result();
	?>
		<option value="All">All Employees</option>
	<?php
		foreach($employees as $row){
	?>
		<option value="<?php echo $row['id']?>"><?php echo $row['emp_name'];?></option>
	<?php
		 }
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
	 }
	
}
