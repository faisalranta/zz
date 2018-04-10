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
		.wrapper {    
			margin-top: 80px;
			margin-bottom: 20px;
		}
	
		.form-signin {
			max-width: 420px;
			padding: 30px 38px 66px;
			margin: 0 auto;
			background-color: #eee;
			border: 3px dotted rgba(0,0,0,0.1);  
		}
	
		.form-signin-heading {
			text-align:center;
			margin-bottom: 30px;
		}
	
		.form-control {
			position: relative;
			font-size: 16px;
			height: auto;
			padding: 10px;
		}
	
		input[type="text"] {
			margin-bottom: 0px;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;
		}
	
		input[type="password"] {
			margin-bottom: 20px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
	
		.colorgraph {
			height: 7px;
			border-top: 0;
			background: #c4e17f;
			border-radius: 5px;
			background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		}
	</style>
</head>
<body>
<div class="navbar-inverse set-radius-zero" >
	<div class="container">
    	<div class="navbar-header">
        	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            	<span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
           	</button>
        </div>
    </div>
</div>
<!-- LOGO HEADER END-->
<!-- Services Section -->
<section class="menu-section">
	<div class="container-fluid">
    	<div class="row ">
			<div class="col-md-12">
				<div class="navbar-collapse collapse ">
					<ul id="menu-top" class="nav navbar-nav" style="margin-bottom: -8px;">
						<a href="{{ url('/') }}" style="float: left; font-size: 25px; 
                        padding: 15px; color: #9170E4; margin-right:10px;" class="triangle-obtuse top">Logo Area</a>&nbsp;&nbsp;
						<li><a href="{{ url('/') }}" class="{{ Request::path() == '/' ? 'triangle-isosceles' : '' }}">Dashboard</a></li>
					   	<li><a href="{{ url('nu/nuViewJobsList') }}" class="{{ Request::is('nu/nuViewJobsList')? 'triangle-isosceles': '' }}">View Jobs List</a></li>
						<li><a href="{{ url('/login') }}" class="{{ Request::is('login')? 'triangle-isosceles': '' }}">Login</a></li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</section>
<!-- MENU SECTION END-->