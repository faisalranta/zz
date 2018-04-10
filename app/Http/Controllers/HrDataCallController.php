<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use Config;

use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\MaritalStatus;
use App\Models\Employee;
use App\Models\Attendence;
use App\Models\Payslip;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\JobType;
class HrDataCallController extends Controller
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
   	public function viewDepartmentList(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$departments = $departments::where('status', '=', '1')->get();
		$counter = 1;
		foreach($departments as $row){
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td><?php echo $row['department_name'];?></td>
			<td></td>
		</tr>
	<?php
		}
	}

	

	public function viewEmployeeListManageAttendence(){
		$_GET['department'];
		$_GET['date'];
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$employees = new Employee;
		
		
		$employees = $employees::where('emp_department_id','=', $_GET['department'])->get();
	?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<input type="hidden" name="get_department_id[]" id="get_department_id" value="<?php echo $_GET['department'];?>" />
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered sf-table-list">
   					<thead>
						<th class="text-center">S.No</th>   
                        <th class="text-center">Emp.No</th>        
						<th class="text-center">Emp. Name</th>
						<th class="text-center">Attendense Status</th>
						<th class="text-center">Reason Of Absence/Leave</th>
					</thead>
					<tbody>
					<?php
						$counter = 1;
						foreach($employees as $row){
					?>
						<tr>
							<td class="text-center"><?php echo $counter++;?></td>
							<td class="text-center"><?php echo $row['emp_no'];?></td>
							<td><?php echo $row['emp_name'];?></td>
							<input type="hidden" name="emp_id_<?php echo $_GET['department'];?>[]" id="emp_id_<?php echo $_GET['department'];?>" value="<?php echo $row['id'];?>" />
							<td>
								<select name="attendense_status_<?php echo $_GET['department'];?>_<?php echo $row['id'];?>" id="attendense_status_<?php echo $_GET['department'];?>_<?php echo $row['id'];?>" class="form-control">
									<option value="1">Present</option>
									<option value="2">Absent</option>
									<option value="3">Leave</option>
								</select>
							</td>
							<td>
								<input type="text" name="attendense_remarks_<?php echo $_GET['department'];?>_<?php echo $row['id'];?>" id="attendense_remarks_<?php echo $_GET['department'];?>_<?php echo $row['id'];?>" class="form-control" value="Ok" />
							</td>
						</tr>	
					<?php
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	
	public function viewAttendenceReport(){
		$getDepartment = $_GET['department'];
		$getMonth = $_GET['month'];
		$startDate = $_GET['month'].'-01';
		$endDate = date("Y-m-t", strtotime($_GET['month']));
		
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$employees = new Employee;
		if($getDepartment == 'All'){
			$departments = $departments::where('status', '=', '1')->get();
		}else{
			$departments = $departments::where('status', '=', '1')
						   ->where('id','=',$getDepartment)->get();
		}
		foreach($departments as $row){
		
	?>
		<div class="panel">
			<div class="panel-heading">
				<?php echo $row['department_name'];?>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php 
						$employees = new Employee;
						$employees = $employees::where('emp_department_id', '=', $row['id'])->get();
						foreach($employees as $row1){
					?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php echo $row1['emp_name'];?>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
							<div class="table-responsive">
								<table class="table table-responsive table-bordered table-striped table-condensed">
                    				<thead>
                        				<tr>
											<?php
												$date1 = strtotime($startDate);
												$date2 = strtotime($endDate);
												while ($date1 <= $date2) {
											?>
												<th class="text-center" style="padding: 4px !important; font-size: 10px;">
													<?php echo date('m-d',$date1);?>
													<?php $date1 = strtotime('+1 day', $date1);?>
												</th>
											<?php
												}
											?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php
												$date3 = strtotime($startDate);
												$date4 = strtotime($endDate);
												while ($date3 <= $date4) {
											?>
												<td class="text-center">
													<?php 
														$attendences = new Attendence;
														$attendences = $attendences::where('emp_id', '=', $row1['id'])
																		->where('attendense_date', '=', date("Y-m-d",$date3))->get();
														foreach($attendences as $row2){
															$row2['attendense_type'];
															if($row2['attendense_type'] == 1){
																echo 'P';
															}else if($row2['attendense_type'] == 2){
																echo 'A';
															}else if($row2['attendense_type'] == 3){
																echo 'L';
															}
														}
													?>
													<?php $date3 = strtotime('+1 day', $date3);?>
												</td>
											<?php 
												}
											?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					<?php 
						}
					?>
				</div>
			</div>
		</div>
		<div class="lineHeight">&nbsp;</div>
	<?php
		}
	}
	
	public function viewEmployeePaysilpForm(){
		$getDepartment = $_GET['department'];
		$getPayslipMonth = $_GET['payslip_month'];
		$getEmployee = $_GET['employee'];
		$startDate = $_GET['payslip_month'].'-1';
		$endDate = date("Y-m-t", strtotime($startDate));;
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$employees = new Employee;
		$departments = $departments::where('status', '=', '1')->where('id','=',$getDepartment)->get();
		foreach($departments as $row){
	?>
		<div class="panel">
			<div class="panel-heading">
				<?php echo $row['department_name'];?>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php 
						$employees = new Employee;
						if($getEmployee == 'All'){
							$employees = $employees::where('emp_department_id', '=', $row['id'])->get();
						}else{
							$employees = $employees::where('emp_department_id', '=', $row['id'])->where('id','=',$getEmployee)->get();
						}
						foreach($employees as $row1){
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<?php echo $row1['emp_name'];?>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive">
										<table class="table table-responsive table-bordered table-striped table-condensed">
											<thead>
												<tr>
													<?php
														$date1 = strtotime($startDate);
														$date2 = strtotime($endDate);
														while ($date1 <= $date2) {
													?>
														<th class="text-center" style="padding: 4px !important; font-size: 10px;">
															<?php echo date('m-d',$date1);?>
															<?php $date1 = strtotime('+1 day', $date1);?>
														</th>
													<?php
														}
													?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<?php
														$date3 = strtotime($startDate);
														$date4 = strtotime($endDate);
														while ($date3 <= $date4) {
													?>
														<td class="text-center">
															<?php 
																$attendences = new Attendence;
																$attendences = $attendences::where('emp_id', '=', $row1['id'])
																				->where('attendense_date', '=', date("Y-m-d",$date3))->get();
																foreach($attendences as $row2){
																	$row2['attendense_type'];
																	if($row2['attendense_type'] == 1){
																		echo 'P';
																	}else if($row2['attendense_type'] == 2){
																		echo 'A';
																	}else if($row2['attendense_type'] == 3){
																		echo 'L';
																	}
																}
															?>
															<?php $date3 = strtotime('+1 day', $date3);?>
														</td>
													<?php 
														}
													?>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="panel-title">Allowances</div>
												</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="table-responsive">
																<table class="table table-responsive table-bordered table-striped table-condensed">
																	<thead>
																		<tr>
																			<th class="text-center">Particular</th>
																			<th class="text-center">Amount</th>
																			<th class="text-center">Action</th>
																		</tr>
																	</thead>
																	<tbody class="addMoreAllowancesDetailRows_<?php echo $row1['id'];?>" id="addMoreAllowancesDetailRows_<?php echo $row1['id'];?>">
																		<tr id="trAllowanceRow_<?php echo $row1['id'];?>_1">
																			<td>
																				<input type="hidden" name="allowancesDataSection_<?php echo $row1['id'];?>[]" class="form-control" id="allowancesDataSection_<?php echo $row1['id'];?>" value="1" />
																				<input type="text" name="allowances_type_<?php echo $row1['id'];?>_1" id="allowances_type_<?php echo $row1['id'];?>_1" value="--" placeholder="Allowance Type" class="form-control" />
																			</td>
																			<td>
																				<input type="number" name="allowances_amount_<?php echo $row1['id'];?>_1" id="allowances_amount_<?php echo $row1['id'];?>_1" value="0" placeholder="Allowance Amount" class="form-control" />
																			</td>
																			<td class="text-center">
																				---
																			</td>
																		</tr>
																	</tbody>
																	<tfoot>
																		<tr>
																			<td colspan="3" class="text-right">
																				<input type="button" class="btn btn-sm btn-primary" onclick="addMoreAllowancesDetailRows(<?php echo $row1['id'];?>)" value="Add More Allowances Rows" />
																				<input type="button" class="btn btn-sm btn-success" onclick="calculateAllowance(<?php echo $row1['id'];?>)" value="Calculate Allowance" />
																			</td>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="panel-title">Deductions</div>
												</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="table-responsive">
																<table class="table table-responsive table-bordered table-striped table-condensed">
																	<thead>
																		<tr>
																			<th class="text-center">Particular</th>
																			<th class="text-center">Amount</th>
																			<th class="text-center">Action</th>
																		</tr>
																	</thead>
																	<tbody class="addMoreDeductionsDetailRows_<?php echo $row1['id'];?>" id="addMoreDeductionsDetailRows_<?php echo $row1['id'];?>">
																		<tr id="trDeductionRow_<?php echo $row1['id'];?>_1">
																			<td>
																				<input type="hidden" name="deductionsDataSection_<?php echo $row1['id'];?>[]" class="form-control" id="deductionsDataSection_<?php echo $row1['id'];?>" value="1" />
																				<input type="text" name="deductions_type_<?php echo $row1['id'];?>_1" id="deductions_type_<?php echo $row1['id'];?>_1" value="--" placeholder="Deduction Type" class="form-control" />
																			</td>
																			<td>
																				<input type="number" name="deductions_amount_<?php echo $row1['id'];?>_1" id="deductions_amount_<?php echo $row1['id'];?>_1" value="0" placeholder="Deduction Amount" class="form-control" />
																			</td>
																			<td class="text-center">
																				---
																			</td>
																		</tr>
																	</tbody>
																	<tfoot>
																		<tr>
																			<td colspan="3" class="text-right">
																				<input type="button" class="btn btn-sm btn-primary" onclick="addMoreDeductionsDetailRows(<?php echo $row1['id'];?>)" value="Add More Deductions Rows" />
																				<input type="button" class="btn btn-sm btn-success" onclick="calculateDeduction(<?php echo $row1['id'];?>)" value="Calculate Deduction" />
																			</td>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="panel">
												<div class="panel-body">
													<div class="row">
														<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
															&nbsp;
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<label>Basic</label>
															<input type="number" id="basic_salary_<?php echo $row1['id'];?>" name="basic_salary_<?php echo $row1['id'];?>" value="<?php echo $row1['emp_salary'];?>" class="form-control" readonly="" />
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<label>Total Allowance</label>
															<input type="number" id="total_allowance_<?php echo $row1['id'];?>" name="total_allowance_<?php echo $row1['id'];?>" value="0" class="form-control" readonly="" />
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<label>Total Deduction</label>
															<input type="number" id="total_deduction_<?php echo $row1['id'];?>" name="total_deduction_<?php echo $row1['id'];?>" value="0" class="form-control" readonly="" />
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<label>Net Salary</label>
															<input type="number" id="net_salary_<?php echo $row1['id'];?>" name="net_salary_<?php echo $row1['id'];?>" value="0" class="form-control" readonly="" />
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<label>Status</label>
															<select name="salary_status_<?php echo $row1['id'];?>" id="salary_status_<?php echo $row1['id'];?>" class="form-control">
																<option value="">Select Status</option>
																<option value="1">Paid</option>
																<option value="2">Un-Paid</option>
															</select>
														</div>
														<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
															&nbsp;
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 
						}
					?>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
						<input type="submit" name="submit" class="btn btn-success" />
					</div>
				</div>
			</div>
		</div>
	<?php
		}
	}
	
	public function viewEmployeePaysilpList(){
		$getDepartment = $_GET['department'];
		$getPayslipMonth = $_GET['payslip_month'];
		$getEmployee = $_GET['employee'];
		$explodePaysilpMonth = explode('-',$getPayslipMonth);
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$departments = new Department;
		$employees = new Employee;
		$departments = $departments::where('status', '=', '1')->where('id','=',$getDepartment)->get();
		foreach($departments as $row){
	?>
		<div class="panel">
			<div class="panel-heading">
				<?php echo $row['department_name'];?>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php 
						$employees = new Employee;
						if($getEmployee == 'All'){
							$employees = $employees::where('emp_department_id', '=', $row['id'])->get();
						}else{
							$employees = $employees::where('emp_department_id', '=', $row['id'])->where('id','=',$getEmployee)->get();
						}
						foreach($employees as $row1){
							$payslips = new Payslip;
							$payslips = $payslips::where('department_id', '=', $row['id'])
										->where('emp_id','=',$row1['id'])
										->where('month','=',$explodePaysilpMonth[1])
										->where('year','=',$explodePaysilpMonth[0])->get();
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="table-responsive">
										<table class="table table-responsive table-bordered table-striped table-condensed">
											<tbody>
												<tr>
													<th>Emp. No.:</th>
													<td><?php echo $row1['emp_no'];?></td>
												</tr>
												<tr>
													<th>Emp. Name:</th>
													<td><?php echo $row1['emp_name'];?></td>
												</tr>
												<tr>
													<th>Month - Year:</th>
													<td><?php echo $explodePaysilpMonth[1].'-'.$explodePaysilpMonth[0];?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									&nbsp;
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="table-responsive">
										<table class="table table-responsive table-bordered table-striped table-condensed">
											<tbody>
												<?php foreach($payslips as $row2){?>
												<tr>
													<th>Payslip Code:</th>
													<td><?php echo $row2['ps_no'];?></td>
												</tr>
												<tr>
													<th>Salary Status:</th>
													<td>
														<?php 
															if($row2['salary_status'] == 1){
																echo 'Paid';
															}else if($row2['salary_status'] == 0){
																echo 'Up-Paid';
															}
														?>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="panel-title">Allowances</div>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="table-responsive">
														<table class="table table-responsive table-bordered table-striped table-condensed">
															<thead>
																<tr>
																	<th class="text-center">S.No</th>
																	<th class="text-center">Particular</th>
																	<th class="text-center">Amount</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$allowances = new Allowance;
																	$acounter = 1;
																	$allowances = $allowances::where('ps_no', '=', $row2['ps_no'])
																				->where('emp_id','=',$row2['emp_id'])->get();
																	foreach($allowances as $row3){
																?>
																<tr>
																	<td class="text-center"><?php echo $acounter++;?></td>
																	<td><?php echo $row3['allowance_type'];?></td>
																	<td class="text-right"><?php echo number_format($row3['allowance_amount'],0);?></td>
																</tr>
																<?php }?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="panel-title">Deductions</div>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="table-responsive">
														<table class="table table-responsive table-bordered table-striped table-condensed">
															<thead>
																<tr>
																	<th class="text-center">S.No</th>
																	<th class="text-center">Particular</th>
																	<th class="text-center">Amount</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$deductions = new Deduction;
																	$dcounter = 1;
																	$deductions = $deductions::where('ps_no', '=', $row2['ps_no'])
																				->where('emp_id','=',$row2['emp_id'])->get();
																	foreach($deductions as $row4){
																?>
																<tr>
																	<td class="text-center"><?php echo $dcounter++;?></td>
																	<td><?php echo $row4['deduction_type'];?></td>
																	<td class="text-right"><?php echo number_format($row4['deduction_amount'],0);?></td>
																</tr>
																<?php }?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									&nbsp;
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="table-responsive">
										<table class="table table-responsive table-bordered table-striped table-condensed">
											<tbody>
												<?php foreach($payslips as $row5){?>
												<tr>
													<th>Basic Salary:</th>
													<th class="text-right"><?php echo number_format($row5['basic_salary'],0);?></th>
												</tr>
												<tr>
													<th>Total Allowance:</th>
													<th class="text-right"><?php echo number_format($row5['total_allowance'],0);?></th>
												</tr>
												<tr>
													<th>Total Deduction:</th>
													<th class="text-right"><?php echo number_format($row5['total_deduction'],0);?></th>
												</tr>
												<tr>
													<th>Net Salary:</th>
													<th class="text-right"><?php echo number_format($row5['net_salary'],0);?></th>
												</tr>
												
												
												<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 
						}
					?>
				</div>
			</div>
		</div>
	<?php
		}
	}
	
	public function viewEmployeeDetail(){
		

		
		$currentDate = date('Y-m-d');
		$id = $_GET['id'];
		$m 	= $_GET['company_id'];
		
		$jobtype = new JobType;
		$departments = new Department;
		$subdepartments = new SubDepartment;
		$marital_status = new MaritalStatus();
		$jobtype = $jobtype::where([['company_id', '=', $_GET['company_id']], ['status', '=', '1'], ])->orderBy('id')->get();;
		$departments = $departments::where([['company_id', '=', $_GET['company_id']], ['status', '=', '1'], ])->orderBy('id')->get();
		$marital_status = $marital_status::where([['company_id', '=',$_GET['company_id']], ['status', '=', '1'], ])->orderBy('id')->get();
		
		
		$d 	= DB::selectOne('select `dbName` from `company` where `id` = '.$m.'')->dbName;
		Config::set(['database.connections.tenant.database' => $d]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$employee_detail = DB::selectOne('select * from `employee` where `id` = '.$id.'');
	
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
		$department_details = DB::selectOne('select sub_department.sub_department_name,department.department_name from 
		`sub_department` inner join department on sub_department.department_id=department.id where sub_department.id = '.$employee_detail->emp_sub_department_id.'');
		?>
		
							<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<div class="table-responsive">
												<table class="table table-bordered sf-table-list">
   													<thead>
														<th class="text-center col-sm-1">Emp.No</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_no;?></td>   
                                        			</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Name</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_name?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Father,s Name</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_father_name;?>o</td>   
                                        			</thead>
													<thead>
														<th class="text-center col-sm-1">Emp DOB</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_date_of_birth?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Gender</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_gender?></td>   
                                        			</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Department</th>   
														<td class="text-center col-sm-1"><?=$department_details->department_name?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Subdepartment</th>   
														<td class="text-center col-sm-1"><?=$department_details->sub_department_name?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Email</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_email?></td>   
                                        			</thead>
													
													
												</table>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<div class="table-responsive">
												<table class="table table-bordered sf-table-list">
   													<thead>
														<th class="text-center col-sm-1">Emp. CNIC</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_cnic?></td>   
                                        			</thead>
													<thead>
														<th class="text-center col-sm-1">Emp. Contact No</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_contact_no?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Job Type</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_employementstatus_id?></td>   
                                        			</thead>
													<thead>
														<th class="text-center col-sm-1">Emp. Salary</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_salary?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Emp Joining Date</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->emp_joining_date?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Created On</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->date?></td>   
                                        			</thead>
													<thead>
														<th class="text-center col-sm-1">Created At</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->time?></td>   
													</thead>
													<thead>
														<th class="text-center col-sm-1">Created By</th>   
														<td class="text-center col-sm-1"><?=$employee_detail->username?></td>   
													</thead>
													
												</table>
											</div>
										</div>
									</div>

	
	<script type="text/javascript">
		$(".btn-success").click(function(e){
			var department = new Array();
			var val;
			$("input[name='departmentSection[]']").each(function(){
    			department.push($(this).val());
			});
			var _token = $("input[name='_token']").val();
			for (val of department) {
				
				jqueryValidationCustom();
				if(validate == 0){
					//alert(response);
				}else{
					return false;
				}
			}
			
		});
	</script>
	
	
	<?php
	}

	public function viewHiringRequestDetail(){
		$id = $_GET['id'];
		$pageType = $_GET['pageType'];
		$parentCode = $_GET['parentCode'];
		$m = $_GET['m'];
	?>
		<br />
		<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.innovative-net.com/&display=popup" target="_blank"> share this facebook </a>
		<?php /*
		?>
		<br />
		<a href="https://twitter.com/intent/tweet?url=http://www.innovative-net.com/about-us/&text=Link+description" target="_blank"> share this twitter </a><?php */
		?>
	<?php
	}


	
	
}
?>