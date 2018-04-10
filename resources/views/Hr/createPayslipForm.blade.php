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
									<span class="subHeadingLabelClass">Manage Payslip Employees</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<?php echo Form::open(array('url' => 'had/createPayslipForm'));?>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<label class="sf-label">Department:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="department_id" id="department_id" required>
                                    					<option value="">Select Employees of a Department</option>
														@foreach($departments as $key => $y)
                                    						<option value="{{ $y->id}}">{{ $y->department_name}}</option>
                                    					@endforeach
                                    				</select>
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<label class="sf-label">Employee:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="employee_id" id="employee_id" required>
													</select>
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<label class="sf-label">Payslip Month:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<input type="month" name="payslip_month" id="payslip_month" value="" class="form-control requiredField" required />
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<input type="button" class="btn btn-sm btn-primary" onclick="manageEmployeePayslip()" value="Manage Employee Payslip" style="margin-top: 32px;" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="employeePayslipSection">
									
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
	function manageEmployeePayslip(){
		var department = $('#department_id').val();
		var employee = $('#employee_id').val();
		var payslip_month = $('#payslip_month').val();
		jqueryValidationCustom();
		if(validate == 0){
			$.ajax({
				url: '<?php echo url('/')?>/hdc/viewEmployeePaysilpForm',
				type: "GET",
				data: { department:department,employee:employee,payslip_month:payslip_month},
				success:function(data) {
					$('.employeePayslipSection').empty();
					$('.employeePayslipSection').append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'+data+'</div>');
           		}
      		});
		}else{
			return false;
		}
	}
	$(function(){
		$('select[name="department_id"]').on('change', function() {
			var departmentID = $(this).val();
			if(departmentID) {
				$.ajax({
					url: '<?php echo url('/')?>/slal/employeeLoadDependentDepartmentID',
					type: "GET",
					data: { id:departmentID},
					success:function(data) {
						$('select[name="employee_id"]').empty();
						$('select[name="employee_id"]').html(data);
                    }
                });
            }else{
                $('select[name="employee_id"]').empty();
            }
        });
	});
	
	var x = 1;
	function addMoreAllowancesDetailRows(id){
		x++;
		$.ajax({
			url: '<?php echo url('/')?>/hmfal/addMoreAllowancesDetailRows',
			type: "GET",
			data: { counter:x,id:id},
			success:function(data) {
				$('.addMoreAllowancesDetailRows_'+id+'').append(data);
          	}
      	});
	}
	
	function removeAllowancesDetailRow(id,counter){
		var elem = document.getElementById('trAllowanceRow_'+id+'_'+counter+'');
    	elem.parentNode.removeChild(elem);
	}
	
	function calculateAllowance(id){
		var totalRows = $('#allowancesDataSection_'+id+'').val();
		//alert(totalRows);
	}
	
	
	
	var d = 1;
	function addMoreDeductionsDetailRows(id){
		d++;
		$.ajax({
			url: '<?php echo url('/')?>/hmfal/addMoreDeductionsDetailRows',
			type: "GET",
			data: { counter:d,id:id},
			success:function(data) {
				$('.addMoreDeductionsDetailRows_'+id+'').append(data);
          	}
      	});
	}
	
	function removeDeductionsDetailRow(id,counter){
		var elem = document.getElementById('trDeductionRow_'+id+'_'+counter+'');
    	elem.parentNode.removeChild(elem);
	}
	
	function calculateDeduction(id){
		alert(id);
	}
</script>
@endsection