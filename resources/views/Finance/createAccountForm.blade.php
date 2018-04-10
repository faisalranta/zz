<?php 
	$accType = Auth::user()->acc_type;
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
									<span class="subHeadingLabelClass">Add Chart of Account</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
												<?php echo Form::open(array('url' => 'fad/addAccountDetail?m='.$m.'','id'=>'chartofaccountForm'));?>
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
    												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<input type="hidden" name="chartofaccountSection[]" class="form-control" id="chartofaccountSection" value="1" />
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    													<label>
        													{{Form::hidden('operational',0)}}
															{{Form::checkbox('operational')}}
															<b>Operational</b>
        												</label>
    												</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<label>Parent Account Head:</label>
														<span class="rflabelsteric"><strong>*</strong></span>
														<select class="form-control requiredField" name="account_id" id="account_id">
                                    						<option value="">Select Account</option>
                                    						@foreach($accounts as $key => $y)
                                    							<option value="{{ $y->code}}">{{ $y->code .' ---- '. $y->name}}</option>
                                    						@endforeach
                                    					</select>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<label for="acc_name">New Account </label>
														<span class="rflabelsteric"><strong>*</strong></span>
														<input type="text" autofocus="autofocus" placeholder="New Account" class="form-control requiredField" name="acc_name" id="acc_name" value="" autocomplete="off" >
    												</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    	 														<label for="o_blnc" >Opening Balance </label>  
																<span class="rflabelsteric"><strong>*</strong></span>             
    															<input type="number" name="o_blnc" maxlength="15" min="0" id="o_blnc" placeholder="Opening Balance" class="form-control requiredField" value="" autocomplete="off"/>
    														</div>
    														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			  													<label for="o_blnc_trans">Transaction </label>
																<span class="rflabelsteric"><strong>*</strong></span>
																<select name="o_blnc_trans" id="o_blnc_trans" class="form-control requiredField">
              														<option value="">select</option>
              														<option value="1"><strong>Debit</strong></option>
               														<option value="0"><strong>Credit</strong></option>
																</select>
    														</div>     
														</div>
													</div>
													<div>&nbsp;</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														{{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
														<button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
													</div>
												<?php
													echo Form::close();
												?>
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
<script>
    $(document).ready(function() {
		$(".btn-success").click(function(e){
			var chartofAccount = new Array();
			var val;
			$("input[name='chartofaccountSection[]']").each(function(){
    			chartofAccount.push($(this).val());
			});
			var _token = $("input[name='_token']").val();
			for (val of chartofAccount) {
				
				jqueryValidationCustom();
				if(validate == 0){
					//return false;
				}else{
					return false;
				}
			}
		});
	});
</script>
@endsection