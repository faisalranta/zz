<?php 
	$accType = Auth::user()->acc_type;
	if($accType == 'client'){
		$m = $_GET['m'];
	}else{
		$m = Auth::user()->company_id;
	}
	$d = DB::selectOne('select `dbName` from `company` where `id` = '.$m.'')->dbName
?>
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
									<span class="subHeadingLabelClass">Create Loan Type Form</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<?php echo Form::open(array('url' => 'had/addLoanTypeDetail?m='.$m.'&&d='.$d.'','id'=>'loanTypeForm'));?>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="pageType" value="<?php echo $_GET['pageType']?>">
								<input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']?>">
								<div class="panel">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<input type="hidden" name="loanTypeSection[]" class="form-control" id="loanTypeSection" value="1" />
											</div>		
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<label>Loan Type Name:</label>
												<span class="rflabelsteric"><strong>*</strong></span>
												<input type="text" name="loan_type_name_1" id="loan_type_name_1" value="" class="form-control requiredField" />
											</div>
										</div>
									</div>
								</div>
								<div class="lineHeight">&nbsp;</div>
								<div class="loanTypeSection"></div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
										{{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
										<button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
										<input type="button" class="btn btn-sm btn-primary addMoreLoanTypeSection" value="Add More Loan Type Section" />
									</div>
								</div>
							<?php echo Form::close();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
    $(document).ready(function() {
		var loanType = 1;
		$('.addMoreLoanTypeSection').click(function (e){
			e.preventDefault();
        	loanType++;
			
			$.ajax({
				url: '<?php echo url('/')?>/hmfal/makeFormLoanTypeDetail',
				type: "GET",
				data: { id:loanType},
				success:function(data) {
					$('.loanTypeSection').append('<div id="sectionLoanType_'+loanType+'"><a href="#" onclick="removeLoanTypeSection('+loanType+')" class="btn btn-xs btn-danger">Remove</a><div class="lineHeight">&nbsp;</div><div class="panel"><div class="panel-body">'+data+'</div></div></div>');
              	}
          	});
		});
		
		// Wait for the DOM to be ready
		$(".btn-success").click(function(e){
			var loanType = new Array();
			var val;
			$("input[name='loanTypeSection[]']").each(function(){
    			loanType.push($(this).val());
			});
			var _token = $("input[name='_token']").val();
			for (val of loanType) {
				
				jqueryValidationCustom();
				if(validate == 0){
					//alert(response);
				}else{
					return false;
				}
			}
			
		});
		
	});
	
	function removeLoanTypeSection(id){
		var elem = document.getElementById('sectionLoanType_'+id+'');
    	elem.parentNode.removeChild(elem);
	}
</script>
@endsection