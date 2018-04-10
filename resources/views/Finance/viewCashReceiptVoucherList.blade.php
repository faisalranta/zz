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
									<span class="subHeadingLabelClass">View Cash Receipt Voucher List</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<input type="hidden" name="functionName" id="functionName" value="fdc/filterCashReceiptVoucherList" readonly="readonly" class="form-control" />
							<input type="hidden" name="tbodyId" id="tbodyId" value="filterCashReceiptVoucherList" readonly="readonly" class="form-control" />
							<input type="hidden" name="m" id="m" value="<?php echo $m?>" readonly="readonly" class="form-control" />
							<input type="hidden" name="baseUrl" id="baseUrl" value="<?php echo url('/')?>" readonly="readonly" class="form-control" />
							
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<label>From Date</label>
									<input type="Date" name="fromDate" id="fromDate" max="<?php echo $current_date;?>" value="<?php echo $currentMonthStartDate;?>" class="form-control" />
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
									<input type="text" readonly class="form-control text-center" value="Between" /></div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<label>To Date</label>
									<input type="Date" name="toDate" id="toDate" max="<?php echo $current_date;?>" value="<?php echo $currentMonthEndDate;?>" class="form-control" />
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
					            	<input type="button" value="View Range Wise Data Filter" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="table-responsive">
														<table class="table table-bordered sf-table-list">
   															<thead>
																<th class="text-center">S.No</th>   
                                        						<th class="text-center">R.V. No.</th>
																<th class="text-center">R.V. Date</th>        
																<th class="text-center">Debit/Credit</th>
																<th class="text-center">Voucher Status</th>
																<th class="text-center">Amount</th>
																<th class="text-center">Total Amount</th>
																<th class="text-center">Action</th>
															</thead>
															<tbody id="filterCashReceiptVoucherList"></tbody>
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
	<script src="{{ URL::asset('assets/custom/js/customFinanceFunction.js') }}"></script>
@endsection