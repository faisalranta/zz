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
class HrEditDetailControler extends Controller
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
   
   	public function editDepartmentDetail(){
		$departmentSection = Input::get('departmentSection');
		foreach($departmentSection as $row){
			$department_name = Input::get('department_name_'.$row.'');
			$department_id = Input::get('department_id_'.$row.'');
			$data1['department_name'] =	strip_tags($department_name);
        	$data1['username'] 		  = Auth::user()->name;
        	$data1['company_id'] 	  	  = $_GET['m'];
        	$data1['date']     		  = date("Y-m-d");
        	$data1['time']     		  = date("H:i:s");
        
			DB::table('department')->where('id', $department_id)->update($data1);	
		}
        Session::flash('dataEdit','successfully edit.');
		return Redirect::to('hr/viewDepartmentList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}


    public function editSubDepartmentDetail(){
        $subDepartmentSection = Input::get('subDepartmentSection');
        foreach($subDepartmentSection as $row){
            $department_id                  = Input::get('department_id_'.$row.'');
            $sub_department_name            = Input::get('sub_department_name_'.$row.'');
            $sub_department_id              = Input::get('sub_department_id_'.$row.'');
            $data1['department_id']         =   strip_tags($department_id);
            $data1['sub_department_name']   =   strip_tags($sub_department_name);
            $data1['username']              = Auth::user()->name;
            $data1['company_id']            = $_GET['m'];
            $data1['date']                  = date("Y-m-d");
            $data1['time']                  = date("H:i:s");
        
            DB::table('sub_department')->where('id', $sub_department_id)->update($data1);    
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewSubDepartmentList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editDesignationDetail(){
        $designationSection = Input::get('designationSection');
        foreach($designationSection as $row){
            $designation_name = Input::get('designation_name_'.$row.'');
            $designation_id = Input::get('designation_id_'.$row.'');
            $data1['designation_name'] = strip_tags($designation_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('designation')->where('id', $designation_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewDesignationList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editHealthInsuranceDetail(){
        $healthInsuranceSection = Input::get('healthInsuranceSection');
        foreach($healthInsuranceSection as $row){
            $health_insurance_name = Input::get('health_insurance_name_'.$row.'');
            $health_insurance_id = Input::get('health_insurance_id_'.$row.'');
            $data1['health_insurance_name'] = strip_tags($health_insurance_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('health_insurance')->where('id', $health_insurance_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewHealthInsuranceList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editLifeInsuranceDetail(){
        $lifeInsuranceSection = Input::get('lifeInsuranceSection');
        foreach($lifeInsuranceSection as $row){
            $life_insurance_name = Input::get('life_insurance_name_'.$row.'');
            $life_insurance_id = Input::get('life_insurance_id_'.$row.'');
            $data1['life_insurance_name'] = strip_tags($life_insurance_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('life_insurance')->where('id', $life_insurance_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewLifeInsuranceList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editJobTypeDetail(){
        $jobTypeSection = Input::get('jobTypeSection');
        foreach($jobTypeSection as $row){
            $job_type_name = Input::get('job_type_name_'.$row.'');
            $job_type_id = Input::get('job_type_id_'.$row.'');
            $data1['job_type_name'] = strip_tags($job_type_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('job_type')->where('id', $job_type_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewJobTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editShiftTypeDetail(){
        $shiftTypeSection = Input::get('shiftTypeSection');
        foreach($shiftTypeSection as $row){
            $shift_type_name = Input::get('shift_type_name_'.$row.'');
            $shift_type_id = Input::get('shift_type_id_'.$row.'');
            $data1['shift_type_name'] = strip_tags($shift_type_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('shift_type')->where('id', $shift_type_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewShiftTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editAdvanceTypeDetail(){
        $advanceTypeSection = Input::get('advanceTypeSection');
        foreach($advanceTypeSection as $row){
            $advance_type_name = Input::get('advance_type_name_'.$row.'');
            $advance_type_id = Input::get('advance_type_id_'.$row.'');
            $data1['advance_type_name'] = strip_tags($advance_type_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('advance_type')->where('id', $advance_type_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewAdvanceTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editLoanTypeDetail(){
        $loanTypeSection = Input::get('loanTypeSection');
        foreach($loanTypeSection as $row){
            $loan_type_name = Input::get('loan_type_name_'.$row.'');
            $loan_type_id = Input::get('loan_type_id_'.$row.'');
            $data1['loan_type_name'] = strip_tags($loan_type_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('loan_type')->where('id', $loan_type_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewLoanTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }

    public function editLeaveTypeDetail(){
        $leaveTypeSection = Input::get('leaveTypeSection');
        foreach($leaveTypeSection as $row){
            $leave_type_name = Input::get('leave_type_name_'.$row.'');
            $leave_type_id = Input::get('leave_type_id_'.$row.'');
            $data1['leave_type_name'] = strip_tags($leave_type_name);
            $data1['username']        = Auth::user()->name;
            $data1['company_id']          = $_GET['m'];
            $data1['date']            = date("Y-m-d");
            $data1['time']            = date("H:i:s");
        
            DB::table('leave_type')->where('id', $leave_type_id)->update($data1);   
        }
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewLeaveTypeList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
    }


    public function editHiringRequestDetail(){
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

        $data1['RequestHiringTitle']        = strip_tags($jobTitle);
        $data1['sub_department_id']         = strip_tags($subDepartmentId);
        $data1['job_type_id']   = strip_tags($jobTypeId);
        $data1['designation_id']        = strip_tags($designationId);
        $data1['qualification_id']  = strip_tags($qualificationId);
        $data1['shift_type_id']     = strip_tags($shiftTypeId);
        $data1['RequestHiringGender']           = strip_tags($gender);
        $data1['RequestHiringSalaryStart']              = strip_tags($salaryStart);
        $data1['RequestHiringSalaryEnd']            = strip_tags($salaryEnd);
        $data1['RequestHiringAge']      = strip_tags($age);
        $data1['RequestHiringDescription']          = strip_tags($jobDescription);
        $data1['RequestHiringStatus']       = 1;
        $data1['username']          = Auth::user()->name;
        $data1['status']            = 1;
        $data1['date']              = date("Y-m-d");
        $data1['time']              = date("H:i:s");

        DB::table('RequestHiring')->where('id', Input::get('RequestHiringId'))->update($data1);
        Config::set('database.default', 'mysql');
        DB::reconnect('mysql');
        Session::flash('dataEdit','successfully edit.');
        return Redirect::to('hr/viewHiringRequestList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$companyId.'#SFR');
    }

    

    

    

    
}
