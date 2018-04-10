<?php 
	$accType = Auth::user()->acc_type;
	if($accType == 'client'){
		$m = $_GET['m'];
	}else{
		$m = Auth::user()->company_id;
	}
	$currentDate = date('Y-m-d');
	Helpers::companyDatabaseConnection($m);
	$pvsDetail = DB::selectOne('select * from `pvs` where `status` = 1 and `pv_no` = "'.$_GET['id'].'"');
	$pvsDataDetail = DB::select('select * from `pv_data` where `status` = 1 and `pv_no` = "'.$_GET['id'].'"');
	$totalRows = count($pvsDataDetail);
?>
Shah Faisal Ranta
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="well">
			<div class="row">
				<?php 
					if($pvsDetail->pv_status == 1){
						echo Form::open(array('url' => 'fad/editBankPaymentPendingVoucherDetail?m='.$m.'','id'=>'bankPaymentVoucherForm'));
				}else if($pvsDetail->pv_status == 2){
					echo Form::open(array('url' => 'fad/editBankPaymentApproveVoucherDetail?m='.$m.'','id'=>'bankPaymentVoucherForm'));
				}
				?>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="pageType" value="<?php echo $_GET['pageType']?>">
				<input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']?>">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="panel">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
											<label class="sf-label">PV No.</label>
											<input type="text" readonly="readonly" class="form-control requiredField" placeholder="PV No" name="pv_no" id="pv_no" value="<?php echo $pvsDetail->pv_no?>" />
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
											<label class="sf-label">Slip No.</label>
											<input type="text" class="form-control requiredField" placeholder="Slip No" name="slip_no" id="slip_no" value="<?php echo $pvsDetail->slip_no?>" />
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label class="sf-label">PV Date.</label>
											<span class="rflabelsteric"><strong>*</strong></span>
											<input type="date" class="form-control requiredField" max="<?php echo date('Y-m-d') ?>" name="pv_date" id="pv_date" value="<?php echo $pvsDetail->pv_date?>" />
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label class="sf-label">Cheque No.</label>
											<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
											<input type="text" class="form-control requiredField" placeholder="Cheque No" name="cheque_no" id="cheque_no" value="<?php echo $pvsDetail->cheque_no?>" />
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label class="sf-label">Cheque Date.</label>
											<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
											<input type="date" class="form-control requiredField" max="<?php echo date('Y-m-d') ?>" name="cheque_date" id="cheque_date" value="<?php echo $pvsDetail->cheque_date?>" />
										</div>
									</div>	
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label class="sf-label">Description</label>
											<span class="rflabelsteric"><strong>*</strong></span>
											<textarea name="description" id="description" style="resize:none;" class="form-control requiredField"><?php echo $pvsDetail->description; ?></textarea>
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
													<table id="buildyourform" class="table table-bordered">
														<thead>
															<tr>
																<th class="text-center">Account Head <span class="rflabelsteric"><strong>*</strong></span></th>
																<th class="text-center" style="width:150px;">Debit <span class="rflabelsteric"><strong>*</strong></span></th>
																<th class="text-center" style="width:150px;">Credit <span class="rflabelsteric"><strong>*</strong></span></th>
																<th class="text-center" style="width:150px;">Action</th>
															</tr>
														</thead>
														<tbody class="addMorePvsDetailRows_1" id="addMorePvsDetailRows_1">

															<?php 
																$j = 1;
																foreach($pvsDataDetail as $row){
																
															?>
																	<input type="hidden" name="pvsDataSection_1[]" class="form-control" id="pvsDataSection_1" value="<?php echo $j?>" />
																	<tr id="removePvsRows_1_<?php echo $j;?>">
																		<td>
																			<select class="form-control requiredField" name="account_id_1_<?php echo $j?>" id="account_id_1_<?php echo $j?>">
																				<option value="">Select Account</option>
																				@foreach($accounts as $key => $y)
																					<option value="{{ $y->id}}" {{ $row->acc_id == $y->id ? 'selected=selected' : '' }}>{{ $y->code .' ---- '. $y->name}}</option>
																				@endforeach
																			</select>
																		</td>
																		<td>
																			<input onfocus="mainDisable('c_amount_1_<?php echo $j ?>','d_amount_1_<?php echo $j ?>');" placeholder="Debit" class="form-control d_amount_1 requiredField" type="text" name="d_amount_1_<?php echo $j ?>" id="d_amount_1_<?php echo $j ?>" onkeyup="sum('1')" value="<?php echo Helpers::dispalyVoucherAmountforEdit($m,'pv_data',$row->acc_id,$row->pv_no,'1',$row->id);?>" required="required"/>
																		</td>
																		<td>
																			<input onfocus="mainDisable('d_amount_1_<?php echo $j ?>','c_amount_1_<?php echo $j ?>');" placeholder="Credit" class="form-control c_amount_1 requiredField" type="text" name="c_amount_1_<?php echo $j ?>" id="c_amount_1_<?php echo $j ?>" onkeyup="sum('1')" value="<?php echo Helpers::dispalyVoucherAmountforEdit($m,'pv_data',$row->acc_id,$row->pv_no,'0',$row->id);?>" required="required"/>
																		</td>
																		<?php if($j <= 2){?>
																			<td class="text-center">---</td>
																		<?php }else{?>
																			<td class="text-center"><a href="#" onclick="removePvsRows(1,'<?php echo $j;?>'),sum('<?php echo '1'?>')" class="btn btn-xs btn-danger">Remove</a></td>
																		<?php }?>
																	</tr>	
															<?php 
																$j++;
																}
															?>
															
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
									<input type="button" class="btn btn-sm btn-primary" onclick="addMorePvsDetailRows('1')" value="Add More PV's Rows" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pvsSection"></div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
						{{ Form::button('Submit', ['class' => 'btn btn-success']) }}
						<button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
					</div>
				</div>
			<?php echo Form::close();?>
			</div>
		</div>
	</div>
</div>
	
<script>
    $(document).ready(function() {
    	sum('1');
		$(".btn-success").click(function(e){
			var pvs = new Array();
			var val;
			pvs.push($(this).val());
			var _token = $("input[name='_token']").val();
			for (val of pvs) {
				jqueryValidationCustom();
				if(validate == 0){
				}else{
					return false;
				}
			}
			formSubmitOne(e);
			
		});
	});
	function formSubmitOne(e){
		
		var postData = $('#bankPaymentVoucherForm').serializeArray();
		var formURL = $('#bankPaymentVoucherForm').attr("action");
		$.ajax({
        	url : formURL,
            type: "POST",
            data : postData,
            success:function(data){
            	$('#showMasterTableEditModel').modal('toggle');
				filterVoucherList();
           	}
        });
	}
	var x = 2;
	function addMorePvsDetailRows(id){
		x++;
		var m = '<?php echo $_GET['m'];?>';
		$.ajax({
			url: '<?php echo url('/')?>/fmfal/addMoreBankPvsDetailRows',
			type: "GET",
			data: { counter:x,id:id,m:m},
			success:function(data) {
				$('.addMorePvsDetailRows_'+id+'').append(data);
          	}
      	});
	}
	
	function removePvsRows(id,counter){
		var elem = document.getElementById('removePvsRows_'+id+'_'+counter+'');
    	elem.parentNode.removeChild(elem);
	}


	
</script>