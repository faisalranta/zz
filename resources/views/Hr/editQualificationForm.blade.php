	<?php 
		$currentDate = date('Y-m-d');
		$id = $_GET['id'];
		$m 	= $_GET['m'];
		$d 	= DB::selectOne('select `dbName` from `company` where `id` = '.$m.'')->dbName;
		$qualificationDetail = DB::selectOne('select * from `qualification` where `id` = '.$id.'');
	?>
	<div class="">
		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="well">
							<?php echo Form::open(array('url' => 'had/editQualificationDetail?m='.$m.'&&d='.$d.'','id'=>'qualificationForm'));?>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="pageType" value="<?php echo $_GET['pageType']?>">
								<input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']?>">
								<div class="panel">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<input type="hidden" name="qualificationSection[]" class="form-control" id="qualificationSection" value="1" />
											</div>		
										</div>
										<input type="hidden" name="qualification_id_1" id="qualification_id_1" value="<?php echo $qualificationDetail->id?>" class="form-control requiredField" />
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
												<label>Qualification Name:</label>
												<span class="rflabelsteric"><strong>*</strong></span>
												<input type="text" name="qualification_name_1" id="qualification_name_1" placeholder="Qualification Name" value="<?php echo $qualificationDetail->qualification_name?>" class="form-control requiredField" />
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
												<label>Institute Name:</label>
												<span class="rflabelsteric"><strong>*</strong></span>
												<input list="datalist_institutes_1" name="institute_name_1" id="institute_name_1" value="" placeholder="Institute Name" class="form-control requiredField" />
												
												<datalist id="datalist_institutes_1">
													@foreach($institutes as $key => $i)
													<option {{ $qualificationDetail->institute_id == $i->id ? 'selected="selected"' : '' }} value="{{ $i->institute_name}}">
													@endforeach
												</datalist>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<label>Country</label>
												<span class="rflabelsteric"><strong>*</strong></span>
												<select name="country_1" id="country_1" class="form-control requiredField" onchange="changeState(this.id)">
													<option value="">Select Country</option>
													@foreach($countries as $key => $y)
                                    					<option value="{{ $y->id}}">{{ $y->nicename}}</option>
                                    				@endforeach
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
												<label>State</label>
												<span class="rflabelsteric"><strong>*</strong></span>
												<select name="state_1" id="state_1" class="form-control requiredField" onchange="changeCity(this.id)">
													<option value="">Select State</option>
												</select>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
												<label>City</label>
												<span class="rflabelsteric"><strong>*</strong></span>
												<select name="city_1" id="city_1" class="form-control requiredField">
													<option value="">Select City</option>
												</select>
											</div>
										</div>

									</div>
								</div>
								<div class="lineHeight">&nbsp;</div>
								<div class="qualificationSection"></div>
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
<script>
    $(document).ready(function() {
		var qualification = 1;
		$('.addMoreQualificationSection').click(function (e){
			e.preventDefault();
        	qualification++;
			
			$.ajax({
				url: '<?php echo url('/')?>/hmfal/makeFormQualificationDetail',
				type: "GET",
				data: { id:qualification},
				success:function(data) {
					$('.qualificationSection').append('<div id="sectionQualification_'+qualification+'"><a href="#" onclick="removeQualificationSection('+qualification+')" class="btn btn-xs btn-danger">Remove</a><div class="lineHeight">&nbsp;</div><div class="panel"><div class="panel-body">'+data+'</div></div></div>');
              	}
          	});
		});
		
		// Wait for the DOM to be ready
		$(".btn-success").click(function(e){
			var qualification = new Array();
			var val;
			$("input[name='qualificationSection[]']").each(function(){
    			qualification.push($(this).val());
			});
			var _token = $("input[name='_token']").val();
			for (val of qualification) {
				
				jqueryValidationCustom();
				if(validate == 0){
					//alert(response);
				}else{
					return false;
				}
			}
			
		});
		
	});

	function changeState(id){
		var res = id.split("_");
		var countryID = $('#'+id+'').val();
		if(countryID) {
			$.ajax({
				url: '<?php echo url('/')?>/slal/stateLoadDependentCountryId',
				type: "GET",
				data: { id:countryID},
				success:function(data) {
					
					$('#city_'+res[1]+'').empty();
					$('#state_'+res[1]+'').empty();
					$('#state_'+res[1]+'').html(data);
             	}
          	});
        }else{
        	$('#city_'+res[1]+'').empty();
			$('#state_'+res[1]+'').empty();
        }
	}
	
	function changeCity(id){
		var res = id.split("_");
		var stateID = $('#'+id+'').val();
		if(stateID) {
			$.ajax({
				url: '<?php echo url('/')?>/slal/cityLoadDependentStateId',
				type: "GET",
				data: { id:stateID},
				success:function(data) {
					$('#city_'+res[1]+'').empty();
					$('#city_'+res[1]+'').html(data);
                }
            });
        }else{
        	$('#city_'+res[1]+'').empty();
        }
	}

	function removeQualificationSection(id){
		var elem = document.getElementById('sectionQualification_'+id+'');
    	elem.parentNode.removeChild(elem);
	}
</script>