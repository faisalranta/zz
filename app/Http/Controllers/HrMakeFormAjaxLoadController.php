<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use Config;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\JobType;
use App\Models\MaritalStatus;
use App\Models\Countries;
use App\Models\Institute;
class HrMakeFormAjaxLoadController extends Controller
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
	 
	public function makeFormDepartmentDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="departmentSection[]" class="form-control" id="departmentSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Department Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="department_name_<?php echo $_GET['id']?>" id="department_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	public function makeFormSubDepartmentDetail(){
		$_GET['id'];
		$departments = new Department;
		$departments = $departments::where('company_id','=',$_GET['companyId'])->where('status','=','1')->orderBy('id')->get();
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="subDepartmentSection[]" class="form-control" id="subDepartmentSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Select Department:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<select class="form-control requiredField" name="department_id_<?php echo $_GET['id']?>" id="department_id_<?php echo $_GET['id']?>">
		        	<option value="">Select Department</option>
		            <?php foreach($departments as $row){?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['department_name'];?></option>
					<?php }?>
		      	</select>
			</div>
		</div>
		<div class="lineHeight">&nbsp;</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Sub Department Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="sub_department_name_<?php echo $_GET['id']?>" id="sub_department_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	
	public function makeFormDesignationDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="designationSection[]" class="form-control" id="designationSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Designation Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="designation_name_<?php echo $_GET['id']?>" id="designation_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	public function makeFormHealthInsuranceDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="healthInsuranceSection[]" class="form-control" id="healthInsuranceSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Health Insurance Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="healthInsurance_name_<?php echo $_GET['id']?>" id="healthInsurance_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	public function makeFormLifeInsuranceDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="lifeInsuranceSection[]" class="form-control" id="lifeInsuranceSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Life Insurance Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="lifeInsurance_name_<?php echo $_GET['id']?>" id="lifeInsurance_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	public function makeFormJobTypeDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="jobTypeSection[]" class="form-control" id="jobTypeSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Job Type Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="job_type_name_<?php echo $_GET['id']?>" id="job_type_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	public function makeFormQualificationDetail(){
		$_GET['id'];
		$countries = new Countries;
		$countries = $countries::where('status', '=', 1)->get();

		$institutes = new Institute;
		$institutes = $institutes::where('status', '=', 1)->get();
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="qualificationSection[]" class="form-control" id="qualificationSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label>Qualification Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="qualification_name_<?php echo $_GET['id']?>" id="qualification_name_<?php echo $_GET['id']?>" placeholder="Qualification Name" value="" class="form-control requiredField" />
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label>Institute Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input list="datalist_institutes_<?php echo $_GET['id']?>" name="institute_name_<?php echo $_GET['id']?>" id="institute_name_<?php echo $_GET['id']?>" value="" placeholder="Institute Name" class="form-control requiredField" />
												
				<datalist id="datalist_institutes_<?php echo $_GET['id']?>">
					<?php foreach($institutes as $row1){?>
						<option value="<?php echo $row1['institute_name']?>">
					<?php }?>
				</datalist>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Country</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<select name="country_<?php echo $_GET['id']?>" id="country_<?php echo $_GET['id']?>" class="form-control requiredField" onchange="changeState(this.id)">
					<option value="">Select Country</option>
					<?php foreach($countries as $row){?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['nicename'];?></option>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label>State</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<select name="state_<?php echo $_GET['id']?>" id="state_<?php echo $_GET['id']?>" class="form-control requiredField" onchange="changeCity(this.id)">
					<option value="">Select State</option>
				</select>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label>City</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<select name="city_<?php echo $_GET['id']?>" id="city_<?php echo $_GET['id']?>" class="form-control requiredField">
					<option value="">Select City</option>
				</select>
			</div>
		</div>
	<?php
	}


	public function makeFormLeaveTypeDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="leaveTypeSection[]" class="form-control" id="leaveTypeSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Leave Type Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="leave_type_name_<?php echo $_GET['id']?>" id="leave_type_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}


	public function makeFormLoanTypeDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="loanTypeSection[]" class="form-control" id="loanTypeSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Loan Type Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="loan_type_name_<?php echo $_GET['id']?>" id="loan_type_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}


	public function makeFormAdvanceTypeDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="advanceTypeSection[]" class="form-control" id="advanceTypeSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Advance Type Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="advance_type_name_<?php echo $_GET['id']?>" id="advance_type_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}

	public function makeFormShiftTypeDetail(){
		$_GET['id'];
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="shiftTypeSection[]" class="form-control" id="shiftTypeSection" value="<?php echo $_GET['id']?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Shift Type Name:</label>
				<span class="rflabelsteric"><strong>*</strong></span>
				<input type="text" name="shift_type_name_<?php echo $_GET['id']?>" id="shift_type_name_<?php echo $_GET['id']?>" value="" class="form-control requiredField" />
			</div>
		</div>
	<?php
	}





	public function makeFormEmployeeDetail(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$_GET['id'];
		$departments = new Department;
		$departments = $departments::orderBy('id')->get();
	?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<input type="hidden" name="employeeSection[]" class="form-control" id="employeeSection" value="<?php echo $_GET['id']?>" />
		</div>		
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Employee Name</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="text" class="form-control requiredField" placeholder="Employee Name" name="employee_name_<?php echo $_GET['id']?>" id="employee_name_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Father Name</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="text" class="form-control requiredField" placeholder="Father Name" name="father_name_<?php echo $_GET['id']?>" id="father_name_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Department</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<select class="form-control requiredField" name="department_id_<?php echo $_GET['id']?>" id="department_id_<?php echo $_GET['id']?>">
				<option value="">Select Department</option>
				<?php foreach($departments as $row){?>
					<option value="<?php echo $row['id'];?>"><?php echo $row['department_name'];?></option>
				<?php }?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Date of Birth</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="date" class="form-control requiredField" placeholder="Date of Birth" name="date_of_birth_<?php echo $_GET['id']?>" id="date_of_birth_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Joining Date</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="date" class="form-control requiredField" placeholder="Joining Date" name="joining_date_<?php echo $_GET['id']?>" id="joining_date_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Gender</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<select class="form-control requiredField" name="gender_<?php echo $_GET['id']?>" id="gender_<?php echo $_GET['id']?>">
				<option value="">Select Gender</option>
				<option value="1">Male</option>
				<option value="2">Female</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">CNIC</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="text" class="form-control requiredField" placeholder="CNIC Number" name="cnic_<?php echo $_GET['id']?>" id="cnic_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Cell No/Mobile No</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="text" class="form-control requiredField" placeholder="Cell No/Mobile No" name="contact_no_<?php echo $_GET['id']?>" id="contact_no_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Employment Status</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<select class="form-control requiredField" name="employee_status_<?php echo $_GET['id']?>" id="employee_status_<?php echo $_GET['id']?>">
				<option value="">Employment Status</option>
				<option value="1">Full Time Contract</option>
				<option value="2">Full Time Internship</option>
				<option value="3">Full Time Permanent</option>
				<option value="4">Part Time Contract</option>
				<option value="5">Part Time Internship</option>
				<option value="6">Part Time Permanent</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Salary</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="number" class="form-control requiredField" placeholder="Salary" name="salary_<?php echo $_GET['id']?>" id="salary_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Email</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<input type="text" class="form-control requiredField" placeholder="Email Address" name="email_<?php echo $_GET['id']?>" id="email_<?php echo $_GET['id']?>" value="" />
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="sf-label">Marital Status</label>
			<span class="rflabelsteric"><strong>*</strong></span>
			<select class="form-control requiredField" name="marital_status_<?php echo $_GET['id']?>" id="marital_status_<?php echo $_GET['id']?>">
				<option value="">Marital Status</option>
				<option value="1">Divorced</option>
				<option value="2">Married</option>
				<option value="3">Single</option>
				<option value="4">Widowed</option>
			</select>
		</div>
	</div>
	<?php
	}
	
	public function addMoreAllowancesDetailRows(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$_GET['id'];
		$_GET['counter'];
	?>
		<tr id="trAllowanceRow_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>">
			<td>
				<input type="hidden" name="allowancesDataSection_<?php echo $_GET['id'];?>[]" class="form-control" id="allowancesDataSection_<?php echo $_GET['id'];?>" value="<?php echo $_GET['counter'];?>" />
				<input type="text" name="allowances_type_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" id="allowances_type_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" value="--" placeholder="Allowance Type" class="form-control" />
			</td>
			<td>
				<input type="number" name="allowances_amount_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" id="allowances_amount_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" value="0" placeholder="Allowance Amount" class="form-control" />
			</td>
			<td class="text-center">
				<a href="#" onclick="removeAllowancesDetailRow(<?php echo $_GET['id'];?>,<?php echo $_GET['counter']?>)" class="btn btn-xs btn-danger">Remove</a>
			</td>
		</tr>
	<?php
	}
	
	
	public function addMoreDeductionsDetailRows(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$_GET['id'];
		$_GET['counter'];
	?>
		<tr id="trDeductionRow_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>">
			<td>
				<input type="hidden" name="deductionsDataSection_<?php echo $_GET['id'];?>[]" class="form-control" id="deductionsDataSection_<?php echo $_GET['id'];?>" value="<?php echo $_GET['counter'];?>" />
				<input type="text" name="deductions_type_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" id="deductions_type_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" value="--" placeholder="Deduction Type" class="form-control" />
			</td>
			<td>
				<input type="number" name="deductions_amount_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" id="deductions_amount_<?php echo $_GET['id'];?>_<?php echo $_GET['counter']?>" value="0" placeholder="Deduction Amount" class="form-control" />
			</td>
			<td class="text-center">
				<a href="#" onclick="removeDeductionsDetailRow(<?php echo $_GET['id'];?>,<?php echo $_GET['counter']?>)" class="btn btn-xs btn-danger">Remove</a>
			</td>
		</tr>
	<?php
	}
	 
}