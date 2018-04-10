<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Employee;
use App\Models\Attendence;
use App\Models\Designation;
use App\Models\HealthInsurance;
use App\Models\LifeInsurance;
use App\Models\JobType;
use App\Models\Countries;
use App\Models\Institute;
use App\Models\Qualification;
use App\Models\LeaveType;
use App\Models\LoanType;
use App\Models\AdvanceType;
use App\Models\ShiftType;
use App\Models\RequestHiring;

use App\Models\Job;
use Input;
use Auth;
use DB;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;
class HrController extends Controller
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
   
   	public function toDayActivity(){
   		return view('Hr.toDayActivity');
   	}
	
	public function departmentAddNView(){
		return view('Hr.departmentAddNView');
	}
	
	public function createDepartmentForm(){
		return view('Hr.createDepartmentForm');
	}
	
	public function viewDepartmentList(){
		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('department')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('department')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','department_name','username']);
        $departments = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewDepartmentList', ['departments' => $departments]);
	}

	public function editDepartmentForm(){
		return view('Hr.editDepartmentForm');
	}

	public function createSubDepartmentForm(){
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->where('status','=','1')->orderBy('id')->get();
		return view('Hr.createSubDepartmentForm',compact('departments'));
	}
	
	public function viewSubDepartmentList(){
		$page = LengthAwarePaginator::resolveCurrentPage();
        $total = DB::table('sub_department')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('sub_department')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','department_id','sub_department_name','username']);
        $SubDepartments = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewSubDepartmentList', ['SubDepartments' => $SubDepartments]);
	}

	public function editSubDepartmentForm(){
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->where('status','=','1')->orderBy('id')->get();
		return view('Hr.editSubDepartmentForm',compact('departments'));
	}

	public function createDesignationForm(){
		return view('Hr.createDesignationForm');
	}
	
	public function viewDesignationList(){

		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('designation')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('designation')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','designation_name','username']);
        $designations = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewDesignationList', ['designations' => $designations]);

	}

	public function editDesignationForm(){
		return view('Hr.editDesignationForm');
	}

	public function createHealthInsuranceForm(){
		return view('Hr.createHealthInsuranceForm');
	}
	
	public function viewHealthInsuranceList(){
		
		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('health_insurance')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('health_insurance')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','health_insurance_name','username']);
        $HealthInsurances = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewHealthInsuranceList', ['HealthInsurances' => $HealthInsurances]);
	}

	public function editHealthInsuranceForm(){
		return view('Hr.editHealthInsuranceForm');
	}

	

	
	public function createLifeInsuranceForm(){
		return view('Hr.createLifeInsuranceForm');
	}

	public function viewLifeInsuranceList(){
		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('life_insurance')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('life_insurance')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','life_insurance_name','username']);
        $LifeInsurances = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewLifeInsuranceList', ['LifeInsurances' => $LifeInsurances]);
	}

	public function editLifeInsuranceForm(){
		return view('Hr.editLifeInsuranceForm');
	}


	public function createJobTypeForm(){
		return view('Hr.createJobTypeForm');
	}

	public function viewJobTypeList(){
		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('job_type')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('job_type')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','job_type_name','username']);
        $JobTypes = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewJobTypeList', ['JobTypes' => $JobTypes]);
	}

	public function editJobTypeForm(){
		return view('Hr.editJobTypeForm');
	}

	public function createQualificationForm(){
		$countries = new Countries;
		$countries = $countries::where('status', '=', 1)->get();

		$institutes = new Institute;
		$institutes = $institutes::where('status', '=', 1)->get();
		
		return view('Hr.createQualificationForm',compact('countries','institutes'));
	}

	public function viewQualificationList(){
		
   		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('qualification')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('qualification')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','qualification_name','institute_id','country_id','state_id','city_id','username']);
        $Qualifications = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewQualificationList', ['Qualifications' => $Qualifications]);
	}

	public function editQualificationForm(){
		$countries = new Countries;
		$countries = $countries::where('status', '=', 1)->get();

		$institutes = new Institute;
		$institutes = $institutes::where('status', '=', 1)->get();
		
		return view('Hr.editQualificationForm',compact('countries','institutes'));
	}

	public function createLeaveTypeForm(){
		return view('Hr.createLeaveTypeForm');
	}

	public function viewLeaveTypeList(){

   		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('leave_type')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('leave_type')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','leave_type_name','username']);
        $LeaveTypes = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewLeaveTypeList', ['LeaveTypes' => $LeaveTypes]);
	}

	public function editLeaveTypeForm(){
		return view('Hr.editLeaveTypeForm');
	}

	public function createLoanTypeForm(){
		return view('Hr.createLoanTypeForm');
	}

	public function viewLoanTypeList(){
		
   		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('loan_type')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('loan_type')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','loan_type_name','username']);
        $LoanTypes = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewLoanTypeList', ['LoanTypes' => $LoanTypes]);
	}

	public function editLoanTypeForm(){
		return view('Hr.editLoanTypeForm');
	}

	public function createAdvanceTypeForm(){
		return view('Hr.createAdvanceTypeForm');
	}

	public function viewAdvanceTypeList(){

   		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('advance_type')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('advance_type')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','advance_type_name','username']);
        $AdvanceTypes = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewAdvanceTypeList', ['AdvanceTypes' => $AdvanceTypes]);
	}

	public function editAdvanceTypeForm(){
		return view('Hr.editAdvanceTypeForm');
	}

	public function createShiftTypeForm(){
		return view('Hr.createShiftTypeForm');
	}

	public function viewShiftTypeList(){
		
   		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('shift_type')->where('status','=','1')->where('company_id','=',$_GET['m'])->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('shift_type')->forPage($page, $perPage)->where('status','=','1')->where('company_id','=',$_GET['m'])->get(['id','shift_type_name','username']);
        $ShiftTypes = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewShiftTypeList', ['ShiftTypes' => $ShiftTypes]);
	}

	public function editShiftTypeForm(){
		return view('Hr.editShiftTypeForm');
	}
	
	

	public function createHiringRequestAddForm(){
		$departments = new Department;
		$JobTypes = new JobType;
		$Designations = new Designation;
		$Qualifications = new Qualification;
		$ShiftTypes = new ShiftType;

		$departments = $departments::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$JobTypes = $JobTypes::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$Designations = $Designations::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$Qualifications = $Qualifications::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$ShiftTypes = $ShiftTypes::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		return view('Hr.createHiringRequestAddForm',compact('departments','JobTypes','Designations','Qualifications','ShiftTypes'));
	}

	public function viewHiringRequestList(){
		$m = $_GET['m'];
		$d = DB::selectOne('select `dbName` from `company` where `id` = '.$m.'')->dbName;
		Config::set(['database.connections.tenant.database' => $d]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');

		$page = LengthAwarePaginator::resolveCurrentPage();
		$total = DB::table('RequestHiring')->where('status','=','1')->count('id'); //Count the total record
        $perPage = 10;
         
        //Set the limit and offset for a given page.
        $results = DB::table('RequestHiring')->forPage($page, $perPage)->where('status','=','1')->get();
        $RequestHiring = new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        return view('Hr.viewHiringRequestList', ['RequestHiring' => $RequestHiring]);
        Config::set('database.default', 'mysql');
		DB::reconnect('mysql');

	}

	public function editHiringRequestAddForm(){
		$departments = new Department;
		$JobTypes = new JobType;
		$Designations = new Designation;
		$Qualifications = new Qualification;
		$ShiftTypes = new ShiftType;

		$departments = $departments::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$JobTypes = $JobTypes::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$Designations = $Designations::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$Qualifications = $Qualifications::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		$ShiftTypes = $ShiftTypes::where('status','=','1')->where('company_id','=',$_GET['m'])->orderBy('id')->get();
		return view('Hr.editHiringRequestAddForm',compact('departments','JobTypes','Designations','Qualifications','ShiftTypes'));
	}

	public function createEmployeeForm(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->orderBy('id')->get();
   		return view('Hr.createEmployeeForm',compact('departments'));
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
	}

	public function viewEmployeeList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$employees = new Employee;
		$employees = $employees::orderBy('id')->get();
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->orderBy('id')->get();
   		return view('Hr.viewEmployeeList',compact('employees','departments'));
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
	}
	
	public function createManageAttendanceForm(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->orderBy('id')->get();
   		return view('Hr.createManageAttendanceForm',compact('departments'));
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
	}
	
	public function viewEmployeeAttendanceList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$employees = new Employee;
		$employees = $employees::orderBy('id')->get();
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->orderBy('id')->get();
		return view('Hr.viewEmployeeAttendanceList',compact('departments','employees'));
	}
	
	public function createPayslipForm(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->orderBy('id')->get();
   		return view('Hr.createPayslipForm',compact('departments'));
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
	}
	
	public function viewPayslipList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['m'])->orderBy('id')->get();
   		return view('Hr.viewPayslipList',compact('departments'));
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
	}

	
	
}
