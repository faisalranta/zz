<?php 
	$accType = Auth::user()->acc_type;
	if($accType == 'client'){
		$m = $_GET['m'];
	}else{
		$m = Auth::user()->company_id;
	}
	$current_date = date('Y-m-d');
	$currentMonthStartDate = date('Y-m-01');
    $currentMonthEndDate   = date('Y-m-t');
?>

@extends('layouts.default')

@section('content')
	<div class="well">
		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						@include('Finance.'.$accType.'financeMenu')
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<span class="subHeadingLabelClass">View Ledger Report</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<input type="hidden" name="functionName" id="functionName" value="fdc/filterViewLedgerReport" readonly="readonly" class="form-control" />
							<input type="hidden" name="tbodyId" id="tbodyId" value="filterViewLedgerReport" readonly="readonly" class="form-control" />
							<input type="hidden" name="m" id="m" value="<?php echo $m?>" readonly="readonly" class="form-control" />
							<input type="hidden" name="baseUrl" id="baseUrl" value="<?php echo url('/')?>" readonly="readonly" class="form-control" />
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label>Account Head:</label>
													<span class="rflabelsteric"><strong>*</strong></span>
													<select class="form-control requiredField" name="account_id" id="account_id">
                                    					<option value="">Select Account</option>
                                    					@foreach($accounts as $key => $y)
                                    						<option value="{{ $y->id}}">{{ $y->code .' ---- '. $y->name}}</option>
                                    					@endforeach
                                    				</select>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<label>From Date</label>
													<input type="Date" name="fromDate" id="fromDate" max="<?php echo $current_date;?>" value="<?php echo $currentMonthStartDate;?>" class="form-control" />
												</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
													<input type="text" readonly class="form-control text-center" value="Between" /></div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<label>To Date</label>
													<input type="Date" name="toDate" id="toDate" max="<?php echo $current_date;?>" value="<?php echo $currentMonthEndDate;?>" class="form-control" />
												</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
									            	<input type="button" value="View" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row" id="mainSection"></div>
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="table-responsive">
														<table class="table table-bordered sf-table-list">
   															<thead>
																<th class="text-center">S.No.</th>   
                                        						<th class="text-center">V.Type</th>
																<th class="text-center">V.No.</th>
																<th class="text-center">Description</th>
																<th class="text-center">Dr.</th>
																<th class="text-center">Cr.</th>
																<th class="text-center">Balance.</th>
																<th class="text-center">Action</th>
															</thead>
															<tbody id="filterViewLedgerReport"></tbody>
														</table>
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
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var baseUrl = $('#baseUrl').val();
		function viewRangeWiseDataFilter() {
			var fromDate = $('#fromDate').val();
			var toDate = $('#toDate').val();
			// Parse the entries
			var startDate = Date.parse(fromDate);
			var endDate = Date.parse(toDate);
			// Make sure they are valid
			if (isNaN(startDate)) {
				alert("The start date provided is not valid, please enter a valid date.");
				return false;
			}
			if (isNaN(endDate)) {
				alert("The end date provided is not valid, please enter a valid date.");
				return false;
			}
			// Check the date range, 86400000 is the number of milliseconds in one day
			var difference = (endDate - startDate) / (86400000 * 7);
			if (difference < 0) {
				alert("The start date must come before the end date.");
				return false;
			}
			filterViewLedgerReport();
		}
		function filterViewLedgerReport(){
			var fromDate = $('#fromDate').val();
			var toDate = $('#toDate').val();
			var functionName = $('#functionName').val();
			var tbodyId = $('#tbodyId').val();
			var m = $('#m').val();
			var currentDate = '<?php echo Helpers::changeDateFormat(date('Y-m-d'));?>';
			var companyName = '<?php echo Helpers::getCompanyName($m);?>';
			var dayName = '<?php echo $nameOfDay = date('l', strtotime(date('Y-m-d'))); ?>';
			var account_id = $('#account_id').val();
			var account_name = $('#account_id option:selected').text();
			$('#'+tbodyId+'').html('<tr><td colspan="8"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');
			$('#mainSection').html('');
			$.ajax({
				url: ''+baseUrl+'/'+functionName+'',
				method:'GET',
				data:{fromDate:fromDate,toDate:toDate,m:m,account_id:account_id},
				error: function(){
					alert('error');
				},
				success: function(response){
					
					setTimeout(function(){
						$('#mainSection').append('<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4"><label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;">'+currentDate+'</label></div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-5"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="font-size: 30px !important; font-style: inherit;font-family: -webkit-body; font-weight: bold;">'+companyName+'</div><div style="line-height:5px;">&nbsp;</div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="font-size: 20px !important; font-style: inherit;font-family: -webkit-body; font-weight: bold;">'+account_name+'</div></div></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right"><label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;">'+dayName+'</label></div></div>');
						$('#'+tbodyId+'').html(response);
					},1000);
				}
			});
		}
		//filterVoucherList();
	</script>
@endsection