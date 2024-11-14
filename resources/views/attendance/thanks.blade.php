<!DOCTYPE html>
<html lang="en">
<head>
	<title>Attendance Form</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- CSRF Token -->
	 <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{ asset($settings->favicon_path) }}"/>
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/vendor/bootstrap/css/bootstrap.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/fonts/iconic/css/material-design-iconic-font.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/vendor/animate/animate.css') }}">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/vendor/css-hamburgers/hamburgers.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/vendor/animsition/css/animsition.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/vendor/select2/select2.min.css') }}">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('Login_v3/css/main.css') }}">
    <!--===============================================================================================-->

	<style>
		.wrap-login100 {
			width: 700px;
			border-radius: 10px;
			overflow: hidden;
			padding: 55px 55px 37px 55px;
			background: #003333;
			background: -webkit-linear-gradient(top, #003333, #1f7a7a);
		}

		.login100-form-btn {
			font-size: 16px;
			color: #1a1a1a;
			justify-content: center;
			align-items: center;
			padding: 0 20px;
			min-width: 120px;
			height: 50px;
			border-radius: 25px;
			background: -webkit-linear-gradient(bottom, #004d00, #004d00);
			position: relative;
			z-index: 1;
			-webkit-transition: all 0.4s;
			-o-transition: all 0.4s;
			-moz-transition: all 0.4s;
			transition: all 0.4s;
		}
	</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url({{ asset('Login_v3/images/bg-02.png') }});">
			<div class="wrap-login100">
				<span class="login100-form-title">
					<img src="{{ asset($settings->logo_login_path) }}" alt="IMG" width="80px">
				</span>
				<br>
				<center><h4 style="color:white"><b>Thank you for your registration</b></h4></center>
				<br><br>
				<div class="container-login100-form-btn">
					<a href="" class="login100-form-btn btn-block">Download File</a>
				</div>
				@if(count($errors) > 0)
                    <br>
                    @if($errors->first('success') != '')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $errors->first('success') }}
                        </div>
                    @else
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $errors->first('error') }}
                        </div>
                    @endif
				@endif
			</div>
		</div>
	</div>

    <!-- SweetAlert Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('sweetalert-1.1.3/css/sweetalert.min.css') }}">
	<script src="{{ asset('sweetalert-1.1.3/js/sweetalert.min.js') }}"></script>
    

    <!--===============================================================================================-->
		<script src="{{ asset('Login_v3/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<!--===============================================================================================-->
		<script src="{{ asset('Login_v3/vendor/animsition/js/animsition.min.js') }}"></script>
	<!--===============================================================================================-->
		<script src="{{ asset('Login_v3/vendor/bootstrap/js/popper.js') }}"></script>
		<script src="{{ asset('Login_v3/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<!--===============================================================================================-->
		<script src="{{ asset('Login_v3/vendor/select2/select2.min.js') }}"></script>
	<!--===============================================================================================-->
		<script src="{{ asset('Login_v3/vendor/daterangepicker/moment.min.js') }}"></script>
		<script src="{{ asset('Login_v3/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<!--===============================================================================================-->
		<script src="{{ asset('Login_v3/vendor/countdowntime/countdowntime.js') }}"></script>
	<!--===============================================================================================-->
		<script src="{{ asset('Login_v3/js/main.js') }}"></script>

		<!-- <script>
			function emailChecking(val) {
        	    var id = document.getElementById("id").value;
        	    var val = val;
        	    $.ajax({
        	        type:"GET",
        	        url:"/trainers/emailchecking/"+id+"/"+val,
        	        success:function(response){
        	            if(response.result == 1) {
        	                $('#email').val(response.email_old);
        	                swal({
        	                    title: "Sorry!",
        	                    text: "This email has been registered in the system. Please use another email.",
        	                    type: "warning",
        	                });
        	            }
        	        }
        	    });
        	}

        	function identificationCardChecking(val) {
        	    var id = document.getElementById("id").value;
        	    var val = val;
        	    $.ajax({
        	        type:"GET",
        	        url:"/trainers/identificationcardchecking/"+id+"/"+val,
        	        success:function(response){
        	            if(response.result == 1) {
        	                $('#profile_identification_card').val(response.identification_card_old);
        	                swal({
        	                    title: "Sorry!",
        	                    text: "This New I/C Number / Passport has been registered in the system. Please use another New I/C Number / Passport.",
        	                    type: "warning",
        	                });
        	            }
        	        }
        	    });
        	}
		</script> -->

</body>
</html>