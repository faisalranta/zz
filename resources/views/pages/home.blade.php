@extends('layouts.default')

@section('content')
    <div class="content-wrapper">
   		<div class="container">
        	<div class="row pad-botm">
            	<div class="col-md-12">
					<?php 
						echo 'Current PHP Version : '. phpversion();
					?>
                	<h4 class="header-line">Make Dashboard Here User Type Wise</h4>
                </div>
			</div>
      	</div>
	</div>
@endsection