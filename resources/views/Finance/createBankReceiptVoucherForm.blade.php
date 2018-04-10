<?php 
	$accType = Auth::user()->acc_type;
	$currentDate = date('Y-m-d');
	if($accType == 'client'){
		$m = $_GET['m'];
	}else{
		$m = Auth::user()->company_id;
	}

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
									<span class="subHeadingLabelClass">Create Bank Receipt Voucher Form</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<?php echo Form::open(array('url' => 'fad/addBankReceiptVoucherDetail?m='.$m.'','id'=>'bankReceiptVoucherForm'));?>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="pageType" value="<?php echo $_GET['pageType']?>">
								<input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']?>">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="hidden" name="rvsSection[]" class="form-control requiredField" id="rvsSection" value="1" />
												</div>		
											</div>
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<div class="row">
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<label class="sf-label">Slip No.</label>
															<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
															<input type="text" class="form-control requiredField" placeholder="Slip No" name="slip_no_1" id="slip_no_1" value="" />
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<label class="sf-label">RV Date.</label>
															<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
															<input type="date" class="form-control requiredField" max="<?php echo date('Y-m-d') ?>" name="rv_date_1" id="rv_date_1" value="<?php echo date('Y-m-d') ?>" />
														</div>
													</div>
													<div class="row">
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<label class="sf-label">Cheque No.</label>
															<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
															<input type="text" class="form-control requiredField" placeholder="Cheque No" name="cheque_no_1" id="cheque_no_1" value="" />
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<label class="sf-label">Cheque Date.</label>
															<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
															<input type="date" class="form-control requiredField" max="<?php echo date('Y-m-d') ?>" name="cheque_date_1" id="cheque_date_1" value="<?php echo date('Y-m-d') ?>" />
														</div>
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<label class="sf-label">Description</label>
                											<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
															<textarea name="description_1" id="description_1" style="resize:none;" class="form-control requiredField"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="lineHeight">&nbsp;</div>
											<div class="well">
												<div class="panel">
													<div class="panel-body">
														<div class="row">
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<div class="table-responsive">
																	<table id="buildyourform" class="table table-bordered  sf-table-th sf-table-form-padding">
																		<thead>
																			<tr>
																				<th class="text-center">Account Head<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
																				<th class="text-center" style="width:150px;">Debit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
																				<th class="text-center" style="width:150px;">Credit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
																				<th class="text-center" style="width:150px;">Action<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
																			</tr>
																		</thead>
																		<tbody class="addMoreRvsDetailRows_1" id="addMoreRvsDetailRows_1">
																			<?php for($j = 1 ; $j <= 2 ; $j++){?>
																			<input type="hidden" name="rvsDataSection_1[]" class="form-control requiredField" id="rvsDataSection_1" value="<?php echo $j?>" />
																			<tr>
																				<td>
																					<select class="form-control requiredField" name="account_id_1_<?php echo $j?>" id="account_id_1_<?php echo $j?>">
                                    													<option value="">Select Account</option>
                                    													@foreach($accounts as $key => $y)
                                    														<option value="{{ $y->id}}">{{ $y->code .' ---- '. $y->name}}</option>
                                    													@endforeach
                                    												</select>
																				</td>
																				<td>
																					<input onfocus="mainDisable('c_amount_1_<?php echo $j ?>','d_amount_1_<?php echo $j ?>');" placeholder="Debit" class="form-control requiredField d_amount_1" maxlength="15" min="0" type="number" name="d_amount_1_<?php echo $j ?>" id="d_amount_1_<?php echo $j ?>" onkeyup="sum('1')" value="" required="required"/>
																				</td>
																				<td>
																					<input onfocus="mainDisable('d_amount_1_<?php echo $j ?>','c_amount_1_<?php echo $j ?>');" placeholder="Credit" class="form-control requiredField c_amount_1" maxlength="15" min="0" type="number" name="c_amount_1_<?php echo $j ?>" id="c_amount_1_<?php echo $j ?>" onkeyup="sum('1')" value="" required="required"/>
																				</td>
																				<td class="text-center">---</td>
																			</tr>
																			<?php }?>
																		</tbody>
																	</table>
																	<table class="table table-bordered">
																		<tbody>
																			<tr>
																				<td></td>
																				<td style="width:150px;">
																					<input 
                  																	type="number"
                  																	readonly="readonly"
                  																	id="d_t_amount_1"
                                        											maxlength="15"
                                       	 											min="0"
                  																	name="d_t_amount_1" 
                               														class="form-control requiredField text-right"
                  																	value=""/>
																				</td>
																				<td style="width:150px;">
																					<input 
                  																	type="number"
                  																	readonly="readonly"
                  																	id="c_t_amount_1"
                                        											maxlength="15"
                                       	 											min="0"
                  																	name="c_t_amount_1" 
                               														class="form-control requiredField text-right"
                  																	value=""/>
																				</td>
																				<td style="width:150px;"></td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
													<input type="button" class="btn btn-sm btn-primary" onclick="addMoreRvsDetailRows('1')" value="Add More RV's Rows" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="rvsSection"></div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
										{{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
										<button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
										<input type="button" class="btn btn-sm btn-primary addMoreRvs" value="Add More RV's Section" />
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
		var r = 1;
		$('.addMoreRvs').click(function (e){
			e.preventDefault();
        	r++;
        	var m = '<?php echo $_GET['m'];?>';
			$.ajax({
				url: '<?php echo url('/')?>/fmfal/makeFormBankReceiptVoucher',
				type: "GET",
				data: { id:r,m:m},
				success:function(data) {
					$('.rvsSection').append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="bankRvs_'+r+'"><a href="#" onclick="removeRvsSection('+r+')" class="btn btn-xs btn-danger">Remove</a><div class="lineHeight">&nbsp;</div><div class="panel"><div class="panel-body">'+data+'</div></div></div>');
              	}
          	});
		});

		$(".btn-success").click(function(e){
			var rvs = new Array();
			var val;
			$("input[name='rvsSection[]']").each(function(){
    			rvs.push($(this).val());
			});
			var _token = $("input[name='_token']").val();
			for (val of rvs) {
				jqueryValidationCustom();
				if(validate == 0){
					//alert(response);
				}else{
					return false;
				}
			}
			
		});
	});
	var x = 2;
	function addMoreRvsDetailRows(id){
		x++;
		var m = '<?php echo $_GET['m'];?>';
		$.ajax({
			url: '<?php echo url('/')?>/fmfal/addMoreBankRvsDetailRows',
			type: "GET",
			data: { counter:x,id:id,m:m},
			success:function(data) {
				$('.addMoreRvsDetailRows_'+id+'').append(data);
          	}
      	});
	}
	
	function removeRvsRows(id,counter){
		var elem = document.getElementById('removeRvsRows_'+id+'_'+counter+'');
    	elem.parentNode.removeChild(elem);
	}
	function removeRvsSection(id){
		var elem = document.getElementById('bankRvs_'+id+'');
    	elem.parentNode.removeChild(elem);
	}
</script>
@endsection