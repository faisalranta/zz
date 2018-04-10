<?php

namespace App\Http\Controllers;
use Illuminate\Database\DatabaseManager;
use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use Config;
use Redirect;
use Session;
use App\Models\Employee;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Institute;
class HrAddDetailControler extends Controller
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
   
   	public function addDepartmentDetail(){
		$departmentSection = Input::get('departmentSection');
		foreach($departmentSection as $row){
			$department_name = Input::get('department_name_'.$row.'');
			$data1['department_name'] =	strip_tags($department_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('department')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewDepartmentList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addSubDepartmentDetail(){
		$subDepartmentSection = Input::get('subDepartmentSection');
		foreach($subDepartmentSection as $row){
			$department_id 					= Input::get('department_id_'.$row.'');
			$sub_department_name 			= Input::get('sub_department_name_'.$row.'');
			$data1['department_id'] 		=	strip_tags($department_id);
			$data1['sub_department_name'] 	=	strip_tags($sub_department_name);
        	$data1['username'] 		  		= Auth::user()->name;
        	$data1['company_id'] 	  	  	= $_GET['m'];
        	$data1['date']     		  		= date("Y-m-d");
        	$data1['time']     		  		= date("H:i:s");
        
			DB::table('sub_department')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewSubDepartmentList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addDesignationDetail(){
		$designationSection = Input::get('designationSection');
		foreach($designationSection as $row){
			$designation_name = Input::get('designation_name_'.$row.'');
			$data1['designation_name'] =	strip_tags($designation_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('designation')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewDesignationList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addHealthInsuranceDetail(){
		$healthInsuranceSection = Input::get('healthInsuranceSection');
		foreach($healthInsuranceSection as $row){
			$healthInsurance_name = Input::get('healthInsurance_name_'.$row.'');
			$data1['health_insurance_name'] =	strip_tags($healthInsurance_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('health_insurance')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewHealthInsuranceList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addLifeInsuranceDetail(){
		$lifeInsuranceSection = Input::get('lifeInsuranceSection');
		foreach($lifeInsuranceSection as $row){
			$lifeInsurance_name = Input::get('lifeInsurance_name_'.$row.'');
			$data1['life_insurance_name'] =	strip_tags($lifeInsurance_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('life_insurance')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewLifeInsuranceList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addJobTypeDetail(){
		$jobTypeSection = Input::get('jobTypeSection');
		foreach($jobTypeSection as $row){
			$job_type_name = Input::get('job_type_name_'.$row.'');
			$data1['job_type_name'] =	strip_tags($job_type_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('job_type')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewJobTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addQualificationDetail(){
		$qualificationSection = Input::get('qualificationSection');
		foreach($qualificationSection as $row){
			$qualification_name = Input::get('qualification_name_'.$row.'');
			$institute_name = Input::get('institute_name_'.$row.'');
			$country = Input::get('country_'.$row.'');
			$state = Input::get('state_'.$row.'');
			$city = Input::get('city_'.$row.'');
			$checkInstituteName = DB::selectOne("select `id`,`institute_name` from `institute` where `status` = 1 and `institute_name` = '".$institute_name."'");
			if(empty($checkInstituteName->id)){
				
				$data1['institute_name']	= strip_tags($institute_name);
				$data1['username'] 		    = Auth::user()->name;
        		$data1['status'] 		 	= 1;
        		$data1['date']     		  	= date("Y-m-d");
        		$data1['time']     		  	= date("H:i:s");
        		$data1['company_id'] 	  	= $_GET['m'];

				$lastInsertedId = DB::table('institute')->insertGetId($data1);

				$data2['qualification_name']	= strip_tags($qualification_name);
				$data2['institute_id']			= strip_tags($lastInsertedId);
				$data2['country_id']			= strip_tags($country);
				$data2['state_id']				= strip_tags($state);
				$data2['city_id']				= strip_tags($city);
				$data2['username'] 		    	= Auth::user()->name;
        		$data2['status'] 		 		= 1;
        		$data2['date']     		  		= date("Y-m-d");
        		$data2['time']     		  		= date("H:i:s");
        		$data2['company_id'] 	  		= $_GET['m'];
				DB::table('qualification')->insert($data2);
        		

			}else{
				$data2['qualification_name']	= strip_tags($qualification_name);
				$data2['institute_id']			= strip_tags($checkInstituteName->id);
				$data2['country_id']			= strip_tags($country);
				$data2['state_id']				= strip_tags($state);
				$data2['city_id']				= strip_tags($city);
				$data2['username'] 		    	= Auth::user()->name;
        		$data2['status'] 		 		= 1;
        		$data2['date']     		  		= date("Y-m-d");
        		$data2['time']     		  		= date("H:i:s");
        		$data2['company_id'] 	  		= $_GET['m'];
				DB::table('qualification')->insert($data2);
			}
			
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewQualificationList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addLeaveTypeDetail(){
		$leaveTypeSection = Input::get('leaveTypeSection');
		foreach($leaveTypeSection as $row){
			$leave_type_name = Input::get('leave_type_name_'.$row.'');
			$data1['leave_type_name'] =	strip_tags($leave_type_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('leave_type')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewLeaveTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addLoanTypeDetail(){
		$loanTypeSection = Input::get('loanTypeSection');
		foreach($loanTypeSection as $row){
			$loan_type_name = Input::get('loan_type_name_'.$row.'');
			$data1['loan_type_name'] =	strip_tags($loan_type_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('loan_type')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewLoanTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addAdvanceTypeDetail(){
		$advanceTypeSection = Input::get('advanceTypeSection');
		foreach($advanceTypeSection as $row){
			$advance_type_name = Input::get('advance_type_name_'.$row.'');
			$data1['advance_type_name'] =	strip_tags($advance_type_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('advance_type')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewAdvanceTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	public function addShiftTypeDetail(){
		$shiftTypeSection = Input::get('shiftTypeSection');
		foreach($shiftTypeSection as $row){
			$shift_type_name = Input::get('shift_type_name_'.$row.'');
			$data1['shift_type_name'] =	strip_tags($shift_type_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('shift_type')->insert($data1);	
		}
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewShiftTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	

	


	public function addHiringRequestDetail(){
		$d = Input::get('dbName');
		$companyId = Input::get('company_id');
		
		Config::set(['database.connections.tenant.database' => $d]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');

		$jobTitle = Input::get('job_title');
		$jobTypeId = Input::get('job_type_id');
		$subDepartmentId = Input::get('sub_department_id');
		$designationId = Input::get('designation_id');
		$qualificationId = Input::get('qualification_id');
		$shiftTypeId = Input::get('shift_type_id');
		$gender = Input::get('gender');
		$salaryStart = Input::get('salary_start');
		$salaryEnd = Input::get('salary_end');
		$age = Input::get('age');
		$jobDescription = Input::get('job_description');

		$str = DB::selectOne("select max(convert(substr(`RequestHiringNo`,4,length(substr(`RequestHiringNo`,4))-4),signed integer)) reg from `RequestHiring` where substr(`RequestHiringNo`,-4,2) = ".date('m')." and substr(`RequestHiringNo`,-2,2) = ".date('y')."")->reg;
			$RequestHiringNo = 'rhn'.($str+1).date('my');

		$data1['RequestHiringNo']			= strip_tags($RequestHiringNo);
		$data1['RequestHiringTitle'] 		= strip_tags($jobTitle);
		$data1['sub_department_id'] 		= strip_tags($subDepartmentId);
		$data1['job_type_id'] 	= strip_tags($jobTypeId);
		$data1['designation_id'] 	 	= strip_tags($designationId);
		$data1['qualification_id'] 	= strip_tags($qualificationId);
		$data1['shift_type_id'] 	= strip_tags($shiftTypeId);
		$data1['RequestHiringGender'] 			= strip_tags($gender);
		$data1['RequestHiringSalaryStart'] 				= strip_tags($salaryStart);
		$data1['RequestHiringSalaryEnd']			= strip_tags($salaryEnd);
		$data1['RequestHiringAge'] 		= strip_tags($age);
		$data1['RequestHiringDescription']			= strip_tags($jobDescription);
		$data1['RequestHiringStatus'] 		= 1;
		$data1['username'] 		    = Auth::user()->name;
        $data1['status'] 		 	= 1;
        $data1['date']     		  	= date("Y-m-d");
        $data1['time']     		  	= date("H:i:s");

        DB::table('RequestHiring')->insert($data1);
        Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
        Session::flash('dataInsert','successfully saved.');
        return Redirect::to('hr/viewHiringRequestList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$companyId.'#SFR');
	}
	
	function addEmployeeDetail(){
		
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$employeeSection = Input::get('employeeSection');
		foreach($employeeSection as $row){
			$employee_name = Input::get('employee_name_'.$row.'');
			$father_name = Input::get('father_name_'.$row.'');
			$department_id = Input::get('department_id_'.$row.'');
			$date_of_birth = Input::get('date_of_birth_'.$row.'');
			$joining_date = Input::get('joining_date_'.$row.'');
			$gender = Input::get('gender_'.$row.'');
			$cnic = Input::get('cnic_'.$row.'');
			$contact_no = Input::get('contact_no_'.$row.'');
			$employee_status = Input::get('employee_status_'.$row.'');
			$salary = Input::get('salary_'.$row.'');
			$email = Input::get('email_'.$row.'');
			$marital_status = Input::get('marital_status_'.$row.'');
			//$department_name = Input::get('department_name');
			
			$str = DB::selectOne("select max(convert(substr(`emp_no`,4,length(substr(`emp_no`,4))-4),signed integer)) reg from `employee` where substr(`emp_no`,-4,2) = ".date('m')." and substr(`emp_no`,-2,2) = ".date('y')."")->reg;
			$employee_no = 'Emp'.($str+1).date('my');
			
			$data1['emp_no'] 				 = strip_tags($employee_no);
			$data1['emp_name'] 				 = strip_tags($employee_name);
			$data1['emp_father_name'] 		 = strip_tags($father_name);
			$data1['emp_department_id'] 	 = strip_tags($department_id);
			$data1['emp_date_of_birth'] 	 = strip_tags($date_of_birth);
			$data1['emp_joining_date'] 		 = strip_tags($joining_date);
			$data1['emp_gender'] 			 = strip_tags($gender);
			$data1['emp_cnic'] 				 = strip_tags($cnic);
			$data1['emp_contact_no'] 		 = strip_tags($contact_no);
			$data1['emp_employementstatus_id'] = strip_tags($employee_status);
			$data1['emp_salary'] 			 = strip_tags($salary);
			$data1['emp_email'] 			 = strip_tags($email);
			$data1['emp_marital_status'] 	 = strip_tags($marital_status);
			$data1['username'] 		 		 = '';
        	$data1['status'] 		 		 = 1;
        	$data1['date']     		  		 = date("Y-m-d");
        	$data1['time']     		  		 = date("H:i:s");
        
			DB::table('employee')->insert($data1);	
		}
		
		$employees = new Employee;
		$employees = $employees::orderBy('id')->get();
		Config::set('database.default', 'mysql');
		
		DB::reconnect('mysql');
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewEmployeeList?pageType=viewlist&&parentCode=7');
		
	}
	
	function addManageAttendenceDetail(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$get_department_id = Input::get('get_department_id');
		$attendence_date = Input::get('attendence_date');
		foreach($get_department_id as $row){
			$emp_id = Input::get('emp_id_'.$row.'');
			foreach($emp_id as $row1){
				$attendense_emp_id = $row1;
				$attendense_status = Input::get('attendense_status_'.$row.'_'.$row1.'');
				$attendense_remarks = Input::get('attendense_remarks_'.$row.'_'.$row1.'');
			
				$data1['emp_id'] 				= strip_tags($row1);
				$data1['department_id'] 		= strip_tags($row);
				$data1['attendense_date'] 		= strip_tags($attendence_date);
				$data1['attendense_type'] 	 	= strip_tags($attendense_status);
				$data1['remarks'] 				= strip_tags($attendense_remarks);
				$data1['username'] 		 		= '';
        		$data1['status'] 		 		= 1;
        		$data1['date']     		  		= date("Y-m-d");
        		$data1['time']     		  		= date("H:i:s");
				DB::table('attendence')->insert($data1);
			}
		}
		Config::set('database.default', 'mysql');
		
		DB::reconnect('mysql');
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewEmployeeAttendanceList?pageType=viewlist&&parentCode=8');
	}
	
	function createPayslipForm(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$department_id = Input::get('department_id');
		$employee_id = Input::get('employee_id');
		$payslip_month = Input::get('payslip_month');
		$employees = new Employee;
		if($employee_id == 'All'){
			$employees = $employees::where('emp_department_id', '=', $department_id)->get();
		}else{
			$employees = $employees::where('emp_department_id', '=', $department_id)->where('id','=',$employee_id)->get();
		}
		foreach($employees as $row){
			$allowancesDataSection = Input::get('allowancesDataSection_'.$row['id'].'');
			$totalAllowanceAmount = 0;
			$totalDeductionAmount = 0;
			$str = DB::selectOne("select max(convert(substr(`ps_no`,4,length(substr(`ps_no`,4))-4),signed integer)) reg from `payslip` where substr(`ps_no`,-4,2) = ".date('m')." and substr(`ps_no`,-2,2) = ".date('y')."")->reg;
			$ps_no = 'psc'.($str+1).date('my');
			foreach($allowancesDataSection as $row1){
				$allowance_type = Input::get('allowances_type_'.$row['id'].'_'.$row1.'');
				$allowance_amount = Input::get('allowances_amount_'.$row['id'].'_'.$row1.'');
				$payslip_month = Input::get('payslip_month');
				$explodeMonthYear = explode('-',$payslip_month);
				$totalAllowanceAmount += $allowance_amount;
				
				$data1['ps_no']					= strip_tags($ps_no);
				$data1['emp_id'] 				= strip_tags($row['id']);
				$data1['department_id'] 		= strip_tags($department_id);
				$data1['month'] 				= strip_tags($explodeMonthYear[1]);
				$data1['year'] 	 				= strip_tags($explodeMonthYear[0]);
				$data1['allowance_type'] 		= strip_tags($allowance_type);
				$data1['allowance_amount'] 		= strip_tags($allowance_amount);
				$data1['username'] 				= '';
        		$data1['status'] 		 		= 1;
        		$data1['date']     		  		= date("Y-m-d");
        		$data1['time']     		  		= date("H:i:s");
				DB::table('allowance')->insert($data1);
			}
			
			$deductionsDataSection = Input::get('deductionsDataSection_'.$row['id'].'');
			foreach($deductionsDataSection as $row1){
				$deduction_type = Input::get('deductions_type_'.$row['id'].'_'.$row1.'');
				$deduction_amount = Input::get('deductions_amount_'.$row['id'].'_'.$row1.'');
				$totalDeductionAmount += $deduction_amount;
				$payslip_month = Input::get('payslip_month');
				$explodeMonthYear = explode('-',$payslip_month);
				
				$data2['ps_no']					= strip_tags($ps_no);
				$data2['emp_id'] 				= strip_tags($row['id']);
				$data2['department_id'] 		= strip_tags($department_id);
				$data2['month'] 				= strip_tags($explodeMonthYear[1]);
				$data2['year'] 	 				= strip_tags($explodeMonthYear[0]);
				$data2['deduction_type'] 		= strip_tags($deduction_type);
				$data2['deduction_amount'] 		= strip_tags($deduction_amount);
				$data2['username'] 				= '';
        		$data2['status'] 		 		= 1;
        		$data2['date']     		  		= date("Y-m-d");
        		$data2['time']     		  		= date("H:i:s");
				DB::table('deduction')->insert($data2);
			}
			$payslip_month = Input::get('payslip_month');
			$basic_salary = Input::get('basic_salary_'.$row['id'].'');
			$salary_status = Input::get('salary_status_'.$row['id'].'');
			$totalAllowanceAmount;
			$netSalary = $basic_salary + $totalAllowanceAmount - $totalDeductionAmount;
			
			$explodeMonthYear = explode('-',$payslip_month);
			
			$data3['ps_no']					= strip_tags($ps_no);
			$data3['emp_id'] 				= strip_tags($row['id']);
			$data3['department_id'] 		= strip_tags($department_id);
			$data3['month'] 				= strip_tags($explodeMonthYear[1]);
			$data3['year'] 	 				= strip_tags($explodeMonthYear[0]);
			$data3['basic_salary'] 			= strip_tags($basic_salary);
			$data3['total_allowance'] 		= strip_tags($totalAllowanceAmount);
			$data3['total_deduction'] 		= strip_tags($totalDeductionAmount);
			$data3['net_salary'] 			= strip_tags($netSalary);
			$data3['salary_status']			= strip_tags($salary_status);
			$data3['username'] 				= '';
        	$data3['status'] 		 		= 1;
        	$data3['date']     		  		= date("Y-m-d");
        	$data3['time']     		  		= date("H:i:s");
			DB::table('payslip')->insert($data3);
			
			
		}
		Config::set('database.default', 'mysql');
		
		DB::reconnect('mysql');
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewPayslipList?pageType=viewlist&&parentCode=9');
		
	}

	
	public function addMaritalStatusDetail(){
		$martitalStatus = Input::get('martitalStatusSection');
		foreach($martitalStatus as $row){
			$martitalStatus_name = Input::get('marital_status_name_'.$row.'');
			$data1['marital_status_name'] =	strip_tags($martitalStatus_name	);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('marital_status')->insert($data1);	
		}
		echo "success";
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('hr/viewMaritalStatuslist?pageType=viewlist&&parentCode=21&&m='.$_GET['m'].'');
	}
	
}
