<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Zam Zama Mall</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="{{ URL::asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="{{ URL::asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" />
	<link href="{{ URL::asset('assets/css/main.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="{{ URL::asset('assets/css/fa.css') }}" rel='stylesheet' type='text/css' />
	<link href="{{ URL::asset('assets/css/arrows.css') }}" rel='stylesheet' type='text/css' />
	<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('assets/js/jquery-1.10.2.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
	<link href="{{ URL::asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
<style type="text/css">
	/*  bhoechie tab */
	div.bhoechie-tab-container{
		z-index: 10;
		background-color: #ffffff;
		padding: 0 !important;
		border-radius: 4px;
		-moz-border-radius: 4px;
		background-clip: padding-box;
		opacity: 0.97;
		filter: alpha(opacity=97);
	}
	div.bhoechie-tab-menu{
		padding-right: 0;
		padding-left: 0;
		padding-bottom: 0;
	}
	div.bhoechie-tab-menu div.list-group{
		margin-bottom: 0;
	}
	div.bhoechie-tab-menu div.list-group>a{
		margin-bottom: 7px;
	}
	
	div.bhoechie-tab-menu div.list-group>a .glyphicon,
	div.bhoechie-tab-menu div.list-group>a .fa {
		color: #31b0d5;
	}
	div.bhoechie-tab-menu div.list-group>a:first-child{
		border-top-right-radius: 0;
		-moz-border-top-right-radius: 0;
	}
	div.bhoechie-tab-menu div.list-group>a:last-child{
		border-bottom-right-radius: 0;
		-moz-border-bottom-right-radius: 0;
	}
	div.bhoechie-tab-menu div.list-group>a.active,
	div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
	div.bhoechie-tab-menu div.list-group>a.active .fa,
	.list-group-item.active, 
	.list-group-item.active:hover, 
	.list-group-item.active:focus{
		background-color: #31b0d5;
		background-image: #31b0d5;
		color: #ffffff;
		padding: 4px;
	}
	div.bhoechie-tab-menu div.list-group>a.active:after,{
		content: '';
		position: absolute;
		left: 100%;
		top: 50%;
		margin-top: -13px;
		border-left: 0;
		border-bottom: 13px solid transparent;
		border-top: 13px solid transparent;
		border-left: 10px solid #31b0d5;
	}
	div.bhoechie-tab-content{
		background-color: #ffffff;
		/* border: 1px solid #eeeeee; */
		padding-left: 20px;
		padding-top: 10px;
	}
	div.bhoechie-tab div.bhoechie-tab-content:not(.active){
		display: none;
	}
	.list-group-item-collaps {
    	margin-bottom: 0;
    	border-bottom-right-radius: 4px;
    	border-bottom-left-radius: 4px;
    	color: #9170E4;
    	font-size: 15px;
    	border-bottom: 5px double #f3961c;
    	padding: 5px;
	}
	
	.rflabelsteric{
		font-size:17px !important; 
		color:red !important;
	}
	a.list-group-item {
   		color: #555;
    	padding: 5px;
	}
	.triangle-isosceles.right:after {
    	top: 12px;
    }
    .modalWidth{
    	width: 80%
    }
</style>
</head>
<body>
		<?php
    		$accType = Auth::user()->acc_type;
    	?>
		@include('includes._'.$accType.'Navigation');
		<div class="container-fluid">
			@if(Session::has('dataInsert'))
    			<div class="row">
    				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
    				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('dataInsert') !!}</em></div>
    				</div>
    			</div>
			@endif
			@if(Session::has('dataDelete'))
    			<div class="row">
    				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
    				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    					<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em> {!! session('dataDelete') !!}</em></div>
    				</div>
    			</div>
			@endif
			@if(Session::has('dataEdit'))
    			<div class="row">
    				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
    				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    					<div class="alert alert-info"><span class="glyphicon glyphicon-ok"></span><em> {!! session('dataEdit') !!}</em></div>
    				</div>
    			</div>
			@endif
			@if(Auth::user()->acc_type == 'client' || Auth::user()->acc_type == 'company')
				@yield('content')
			@else
			<?php
				$roleNo = Auth::user()->role_no;
				$getColumnName = 'right_'.app('request')->input('pageType').'';
				$getParentCode = app('request')->input('parentCode');
				Config::set('database.default', 'mysql');
				DB::reconnect('mysql');
				if(app('request')->input('parentCode') == ''){
					$roleDetail = 0;
				}else if(app('request')->input('parentCode') == 0){
					$roleDetail = 1;
				}else{
					$roleDetail = DB::selectOne('select '.$getColumnName.' as columnName from `role_detail` where `menu_id` = '.$getParentCode.' and `role_no` = "'.$roleNo.'"')->columnName;
				}
				if($roleDetail == 1){
			?>
					@yield('content')
    		<?php 
				}else{
					echo 'No Permission';
				}
			?>
			@endif
		</div>
<script>
	//$(document).ready(function(){
    	setTimeout(function() {
            $('.alert-success').fadeOut('fast');
            }, 500);
    	setTimeout(function() {
            $('.alert-danger').fadeOut('fast');
            }, 500);
    	setTimeout(function() {
            $('.alert-info').fadeOut('fast');
            }, 500);
   	//});
	function showDetailModelOneParamerter(url,id,modalName){
		<?php
			if(!empty($_GET['pageType'])){
		?>
			var pageType = '<?php echo $_GET['pageType'];?>';
			var parentCode = '<?php echo $_GET['parentCode'];?>';
			var m = '<?php echo $_GET['m'];?>';
		<?php 
			}
		?>
		$.ajax({

			url: '<?php echo url('/')?>/'+url+'',
			type: "GET",
			data: {id:id,pageType:pageType,parentCode:parentCode,m:m},
			success:function(data) {
				
				jQuery('#showDetailModelOneParamerter').modal('show', {backdrop: 'false'});
				jQuery('#showDetailModelOneParamerter .modalTitle').html(modalName);
				jQuery('#showDetailModelOneParamerter .modal-body').html('<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div>');
				setTimeout(function(){
					jQuery('#showDetailModelOneParamerter .modal-body').html(data);
				},1000);
				
				
			}
      	});
	}

	function showDetailModelTwoParamerter(url,id,modalName,m){
		<?php
			if(!empty($_GET['pageType'])){
		?>
			var pageType = '<?php echo $_GET['pageType'];?>';
			var parentCode = '<?php echo $_GET['parentCode'];?>';
			var m = '<?php echo $_GET['m'];?>';
		<?php 
			}else{
		?>
			var m = m;
		<?php	
			}
		?>
		$.ajax({

			url: '<?php echo url('/')?>/'+url+'',
			type: "GET",
			data: {id:id,pageType:pageType,parentCode:parentCode,m:m},
			success:function(data) {
				
				jQuery('#showDetailModelTwoParamerter').modal('show', {backdrop: 'false'});
				jQuery('#showDetailModelTwoParamerter .modalTitle').html(modalName);
				jQuery('#showDetailModelTwoParamerter .modal-body').html('<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div>');
				setTimeout(function(){
					jQuery('#showDetailModelTwoParamerter .modal-body').html(data);
				},1000);
				
				
			}
      	});
	}
	
	var validate = 0;
	
	function jqueryValidationCustom(){
		var requiredField = document.getElementsByClassName('requiredField');
		for (i = 0; i < requiredField.length; i++){
			var rf = requiredField[i].id;
			var checkType = requiredField[i].type;
			/*if(checkType == 'text'){
				alert('Please type text');
			}else if(checkType == 'select-one'){
				alert('Please select one option');
			}else if(checkType == 'number'){
				alert('Please type number');
			}else if(checkType == 'date'){
				alert('Please type date');
			}*/
			if($('#'+rf).val() == ''){
				$('#'+rf).css('border-color', 'red');
				$('#'+rf).focus();
				validate = 1;
				return false;
			}else{
				$('#'+rf).css('border-color', '#ccc');
			}
		}
		
		var requiredField1 = document.getElementsByClassName('requiredField');
		for (i = 0; i < requiredField1.length; i++){
			var rf1 = requiredField[i].id;
			if($('#'+rf1+'').val() == ''){
				validate = 1;
			}else{
				validate = 0;
			}
		}
	}
	
	function sum(id){
		var sum_amount = 0;
 		var sum_amount2 = 0; 
		$("input[class *= 'd_amount_"+id+"']").each(function(){
        	sum_amount += +$(this).val();
    	});
		//alert(sum_amount);
    	$('#d_t_amount_'+id+'').val(parseFloat(sum_amount.toFixed(3)));

    	$("input[class *= 'c_amount_"+id+"']").each(function(){
        	sum_amount2 += +$(this).val();
    	});
    	$('#c_t_amount_'+id+'').val(parseFloat(sum_amount2.toFixed(3)));
		if ($('#d_t_amount_'+id+'').val() != $('#c_t_amount_'+id+'').val()){
			$('#d_t_amount_'+id+'').css('background-color','#C00');
			$('#d_t_amount_'+id+'').css('color','#fff');		
			$('#c_t_amount_'+id+'').css('background-color','#C00');
			$('#c_t_amount_'+id+'').css('color','#fff');		
		}else{
			$('#d_t_amount_'+id+'').removeAttr('style');	
			$('#c_t_amount_'+id+'').removeAttr('style');			
		}
		toWords(id); 
	}
	
	var th = ['','Thousand','Million', 'Billion','Trillion'];
	var dg = ['Zero','One','Two','Three','Four', 'Five','Six','Seven','Eight','Nine'];
 	var tn = ['Ten','Eleven','Twelve','Thirteen', 'Fourteen','Fifteen','Sixteen', 'Seventeen','Eighteen','Nineteen'];
 	var tw = ['Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];
	function toWords(id) {
		s = $('#d_t_amount_'+id+'').val();
    	s = s.toString();
    	s = s.replace(/[\, ]/g,'');
    	if (s != parseFloat(s)) return 'not a number';
    	var x = s.indexOf('.');
    	if (x == -1)
        	x = s.length;
    	if (x > 15)
     	   return 'too big';
    	var n = s.split(''); 
    	var str = '';
    	var sk = 0;
    	for (var i=0;   i < x;  i++) {
        	if ((x-i)%3==2) { 
            	if (n[i] == '1') {
                	str += tn[Number(n[i+1])] + ' ';
                	i++;
                	sk=1;
            	} else if (n[i]!=0) {
                	str += tw[n[i]-2] + ' ';
                	sk=1;
            	}
        	} else if (n[i]!=0) { // 0235
            	str += dg[n[i]] +' ';
            	if ((x-i)%3==0) str += 'hundred ';
            	sk=1;
        	}
        	if ((x-i)%3==1) {
            	if (sk)
                	str += th[(x-i-1)/3] + ' ';
            		sk=0;
        		}
    		}

    		if (x != s.length) {
        		var y = s.length;
        		str += 'point ';
        		for (var i=x+1; i<y; i++)
            		str += dg[n[i]] +' ';
    		}
    		result = str.replace(/\s+/g,' ')+'Only';
			//$('#rupees').val(result);
	};

	function deleteRowMasterTable(value,id,tableName){
		var value;
		var id;
		var tableName;
		$.ajax({
			url: '<?php echo url('/')?>/deleteMasterTableReceord',
			type: "GET",
			data: {value:value,id:id,tableName:tableName},
			success:function(data) {
				location.reload();
			}
      	});

	}

	function deleteRowCompanyHRRecords(companyId,recordId,tableName){
		var companyId;
		var recordId;
		var tableName;
		$.ajax({
			url: '<?php echo url('/')?>/cdOne/deleteRowCompanyHRRecords',
			type: "GET",
			data: {companyId:companyId,recordId:recordId,tableName:tableName},
			success:function(data) {
				location.reload();
			}
      	});

	}

	function showMasterTableEditModel(url,id,modalName,m){
		<?php
			if(!empty($_GET['pageType'])){
		?>
			var pageType = '<?php echo $_GET['pageType'];?>';
			var parentCode = '<?php echo $_GET['parentCode'];?>';
		<?php 
			}
		?>
		$.ajax({
			url: '<?php echo url('/')?>/'+url+'',
			type: "GET",
			data: {id:id,m:m,pageType:pageType,parentCode:parentCode},
			success:function(data) {
				
				jQuery('#showMasterTableEditModel').modal('show', {backdrop: 'false'});
				jQuery('#showMasterTableEditModel .modalTitle').html(modalName);
				jQuery('#showMasterTableEditModel .modal-body').html('<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div>');
				setTimeout(function(){
					jQuery('#showMasterTableEditModel .modal-body').html(data);
				},1000);
				
				
			}
      	});
	}

	function mainDisable(disable,enable){
		if ($('#'+disable).val() == ""){		
			$('#'+disable).attr('readonly','readonly');
			$('#'+disable).removeAttr('required','required');
			$('#'+disable).removeClass("requiredField")
			$('#'+disable).val("");	
			$('#'+enable).removeAttr('readonly');	
			$('#'+enable).attr('required','required');
			$('#'+enable).addClass("requiredField")
		}
	}

</script>
<div class="modal fade" id="showDetailModelOneParamerter">
	<div class="modal-dialog modalWidth">
    	<div class="modal-content">
        	<div class="modal-header" style=" padding: 15px; background-color: #f7f7f7; border-bottom: 5px solid #9170E4; width: 100%;">
            	<div class="row">
                	<div class="col-md-4 col-sm-1 col-xs-12 text-center">
                		<a style="float: left; font-size: 15px; 
                        color: #9170E4; margin-right:10px; margin: -9px 0px -31px 0px;" class="triangle-obtuse top">Logo Area</a>
                	</div>
					<div class="col-md-4 col-sm-1 col-xs-12 text-center">
						<span class="modalTitle subHeadingLabelClass"></span>
					</div>
               		<div class="col-md-4 col-sm-1 col-xs-12 text-right">
                    	<button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
            <div  class="modal-body"></div>
			<div class="modal-footer" style=" padding: 15px; background-color: #f7f7f7; border-top: 5px solid #9170E4; width: 100%;">
    			<div class="row">
        			<div class="text-center">
            			&copy; <?php echo date('Y')?> Innovative-net.com |<a href="http://www.innovative-net.com/" target="_blank"  > Designed by : innovative-net.com</a>
					</div>
				</div>
      		</div>
        </div>
    </div>
</div>


<div class="modal fade" id="showDetailModelTwoParamerter">
	<div class="modal-dialog modalWidth">
    	<div class="modal-content">
        	<div class="modal-header" style=" padding: 15px; background-color: #f7f7f7; border-bottom: 5px solid #9170E4; width: 100%;">
            	<div class="row">
                	<div class="col-md-4 col-sm-1 col-xs-12 text-center">
                		<a style="float: left; font-size: 15px; 
                        color: #9170E4; margin-right:10px; margin: -9px 0px -31px 0px;" class="triangle-obtuse top">Logo Area</a>
                	</div>
					<div class="col-md-4 col-sm-1 col-xs-12 text-center">
						<span class="modalTitle subHeadingLabelClass"></span>
					</div>
               		<div class="col-md-4 col-sm-1 col-xs-12 text-right">
                    	<button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
            <div  class="modal-body"></div>
			<div class="modal-footer" style=" padding: 15px; background-color: #f7f7f7; border-top: 5px solid #9170E4; width: 100%;">
    			<div class="row">
        			<div class="text-center">
            			&copy; <?php echo date('Y')?> Innovative-net.com |<a href="http://www.innovative-net.com/" target="_blank"  > Designed by : innovative-net.com</a>
					</div>
				</div>
      		</div>
        </div>
    </div>
</div>


<div class="modal fade" id="showDetailModelTwoParamerter">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
        	<div class="modal-header" style=" padding: 15px; background-color: #f7f7f7; border-bottom: 5px solid #9170E4; width: 100%;">
            	<div class="row">
                	<div class="col-md-4 col-sm-1 col-xs-12 text-center">
                		<a style="float: left; font-size: 15px; 
                        color: #9170E4; margin-right:10px; margin: -9px 0px -31px 0px;" class="triangle-obtuse top">Logo Area</a>
                	</div>
					<div class="col-md-4 col-sm-1 col-xs-12 text-center">
						<span class="modalTitle subHeadingLabelClass"></span>
					</div>
               		<div class="col-md-4 col-sm-1 col-xs-12 text-right">
                    	<button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
            <div  class="modal-body"></div>
			<div class="modal-footer" style=" padding: 15px; background-color: #f7f7f7; border-top: 5px solid #9170E4; width: 100%;">
    			<div class="row">
        			<div class="text-center">
            			&copy; <?php echo date('Y')?> Innovative-net.com |<a href="http://www.innovative-net.com/" target="_blank"  > Designed by : innovative-net.com</a>
					</div>
				</div>
      		</div>
        </div>
    </div>
</div>

<div class="modal fade" id="showMasterTableEditModel">
	<div class="modal-dialog modalWidth">
    	<div class="modal-content">
        	<div class="modal-header" style=" padding: 15px; background-color: #f7f7f7; border-bottom: 5px solid #9170E4; width: 100%;">
            	<div class="row">
                	<div class="col-md-4 col-sm-1 col-xs-12 text-center">
                		<a style="float: left; font-size: 15px; 
                        color: #9170E4; margin-right:10px; margin: -9px 0px -31px 0px;" class="triangle-obtuse top">Logo Area</a>
                	</div>
					<div class="col-md-4 col-sm-1 col-xs-12 text-center">
						<span class="modalTitle subHeadingLabelClass"></span>
					</div>
               		<div class="col-md-4 col-sm-1 col-xs-12 text-right">
                    	<button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
            <div  class="modal-body"></div>
			<div class="modal-footer" style=" padding: 15px; background-color: #f7f7f7; border-top: 5px solid #9170E4; width: 100%;">
    			<div class="row">
        			<div class="text-center">
            			&copy; <?php echo date('Y')?> Innovative-net.com |<a href="http://www.innovative-net.com/" target="_blank"  > Designed by : innovative-net.com</a>
					</div>
				</div>
      		</div>
        </div>
    </div>
</div>
		@include('includes._footer')
</body>
</html>