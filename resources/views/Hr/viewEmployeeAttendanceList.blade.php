@extends('layouts.default')

@section('content')
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
									<span class="subHeadingLabelClass">View Employee Attendence List</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Employees By Department:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="department_id" id="department_id" required>
														<option value="">Select Employees of a Department</option>
														<option value="All">All Department</option>
														@foreach($departments as $key => $y)
															<option value="{{ $y->id}}">{{ $y->department_name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label class="sf-label">Month - Year</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="month" name="attendence_month" id="attendence_month" value="" class="form-control requiredField" required />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<input type="button" class="btn btn-sm btn-primary" id="showAttendenceReport" onclick="showAttendenceReport()" value="Show Attendence Report" style="margin-top: 32px;" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="employeeAttendenceReportSection"></div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
    function showAttendenceReport(){
		var department = $('#department_id').val();
		var month = $('#attendence_month').val();
		jqueryValidationCustom();
		if(validate == 0){
			$.ajax({
				url: '<?php echo url('/')?>/hdc/viewAttendenceReport',
				type: "GET",
				data: { department:department,month:month},
				success:function(data) {
					$('.employeeAttendenceReportSection').empty();
					$('.employeeAttendenceReportSection').append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'+data+'</div>');
				}
			});
		}else{
			return false;
		}
	}
</script>
@endsection