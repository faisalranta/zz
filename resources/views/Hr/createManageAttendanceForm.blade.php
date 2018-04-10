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
						@include('Hr.hrMenu')
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<span class="subHeadingLabelClass">Manage Attendence Employees</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<?php echo Form::open(array('url' => 'had/addManageAttendenceDetail'));?>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Employees By Department:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="department_id" id="department_id" required>
                                    					<option value="">Select Employees of a Department</option>
														@foreach($departments as $key => $y)
                                    						<option value="{{ $y->id}}">{{ $y->department_name}}</option>
                                    					@endforeach
                                    				</select>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Date:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
													<input type="date" name="attendence_date" id="attendence_date" value="<?php echo $currentDate?>" class="form-control requiredField" required />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<input type="button" class="btn btn-sm btn-primary" onclick="manageAttendence()" value="Manage Employee Attendence" style="margin-top: 32px;" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="employeeAttendenceSection"></div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
										{{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
										<button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
										
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
    function manageAttendence(){
		var department = $('#department_id').val();
		var date = $('#attendence_date').val();
		jqueryValidationCustom();
		if(validate == 0){
			$.ajax({
				url: '<?php echo url('/')?>/hdc/viewEmployeeListManageAttendence',
				type: "GET",
				data: { department:department,date:date},
				success:function(data) {
					$('.employeeAttendenceSection').empty();
					$('.employeeAttendenceSection').append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="sectionEmployeeAttendense_'+department+'"><a href="#" onclick="removeEmployeeAttendenseSection('+department+')" class="btn btn-xs btn-danger">Remove</a><div class="lineHeight">&nbsp;</div><div class="panel"><div class="panel-body">'+data+'</div></div></div>');
           		}
      		});
		}else{
			return false;
		}
	}
	
	function removeEmployeeAttendenseSection(id){
		var elem = document.getElementById('sectionEmployeeAttendense_'+id+'');
    	elem.parentNode.removeChild(elem);
	}
</script>
@endsection