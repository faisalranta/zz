<?php $accType = Auth::user()->acc_type;?>
@extends('layouts.default')

@section('content')
	<?php 
		$currentDate = date('Y-m-d');
	?>
	<div class="well">
		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						@include('Hr.'.$accType.'hrMenu')
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<span class="subHeadingLabelClass">Create Employee Form</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<?php echo Form::open(array('url' => 'had/addEmployeeDetail','id'=>'employeeForm'));?>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="hidden" name="employeeSection[]" class="form-control" id="employeeSection" value="1" />
												</div>		
											</div>
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Employee Name</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="text" class="form-control requiredField" placeholder="Employee Name" name="employee_name_1" id="employee_name_1" value="" />
													
													
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Father Name</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="text" class="form-control requiredField" placeholder="Father Name" name="father_name_1" id="father_name_1" value="" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Department</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="department_id_1" id="department_id_1">
                                    					<option value="">Select Department</option>
                                    					@foreach($departments as $key => $y)
                                    						<option value="{{ $y->id}}">{{ $y->department_name}}</option>
                                    					@endforeach
                                    				</select>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Date of Birth</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="date" class="form-control requiredField" placeholder="Date of Birth" name="date_of_birth_1" id="date_of_birth_1" value="" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Joining Date</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="date" class="form-control requiredField" placeholder="Joining Date" name="joining_date_1" id="joining_date_1" value="" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Gender</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="gender_1" id="gender_1">
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
													<input type="text" class="form-control requiredField" placeholder="CNIC Number" name="cnic_1" id="cnic_1" value="" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Cell No/Mobile No</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="text" class="form-control requiredField" placeholder="Cell No/Mobile No" name="contact_no_1" id="contact_no_1" value="" />
												</div>
												
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Employment Status</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="employee_status_1" id="employee_status_1">
													<option value="">Select Employment Status</option>
													@foreach($jobtype as $key3 => $value)
													<option value="{{ $value->id}}">{{ $value->job_type_name}}</option>
													@endforeach		
                                    				</select>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Salary</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="number" class="form-control requiredField" placeholder="Salary" name="salary_1" id="salary_1" value="" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Email</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="text" class="form-control requiredField" placeholder="Email Address" name="email_1" id="email_1" value="" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Marital Status</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="marital_status_1" id="marital_status_1">
                                    					<option value="">Select Marital</option>
                                    					@foreach($marital_status as $key4 => $value2)
														<option value="{{ $value2->id}}">{{ $value2->marital_status_name}}</option>
														@endforeach		
                                    				</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="employeeSection"></div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
										{{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
										<button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
										<input type="button" class="btn btn-sm btn-primary addMoreEmployeeSection" value="Add More Employee's Section" />
									</div>
								</div>
							<?php echo Form::close();?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
    $(document).ready(function() {
		var employee = 1;
		$('.addMoreEmployeeSection').click(function (e){
			e.preventDefault();
        	employee++;
			
			$.ajax({
				url: '<?php echo url('/')?>/hmfal/makeFormEmployeeDetail',
				type: "GET",
				data: { id:employee},
				success:function(data) {
					$('.employeeSection').append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="sectionEmployee_'+employee+'"><a href="#" onclick="removeEmployeeSection('+employee+')" class="btn btn-xs btn-danger">Remove</a><div class="lineHeight">&nbsp;</div><div class="panel"><div class="panel-body">'+data+'</div></div></div>');
              	}
          	});
		});
		
		// Wait for the DOM to be ready
		$(".btn-success").click(function(e){
			var employee = new Array();
			var val;
			$("input[name='employeeSection[]']").each(function(){
    			employee.push($(this).val());
			});
			var _token = $("input[name='_token']").val();
			for (val of employee) {
    			jqueryValidationCustom();
				if(validate == 0){
					//alert(response);
				}else{
					return false;
				}
			}
			
		});
		
	});
	
	function removeEmployeeSection(id){
		var elem = document.getElementById('sectionEmployee_'+id+'');
    	elem.parentNode.removeChild(elem);
	}
</script>
@endsection