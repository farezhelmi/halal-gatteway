<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $settings->title }}</title>
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
			width: 500px;
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
				<form action="{{ route('login') }}" method="post" class="login100-form validate-form">
					<span class="login100-form-title">
						<img src="{{ asset($settings->logo_login_path) }}" alt="IMG" width="100px">
					</span>

					<br>
					<center><h2 style="color:white"><b>{{ $settings->title }}</b></h2></center>
					<br><br>

					@if(count($errors) > 0)
                        <br>
                        @if($errors->first('username') != '')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ $errors->first('username') }}
                            </div>
                        @else
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
					@endif

                    <br>
                    <div style="color: white;">
                        <span style="font-size:14px;">You forgot your password?<br>Here you can easily retrieve a new password.</span>
                    </div>
                    <br><br>

					<div class="wrap-input100 validate-input" data-validate = "Please insert your email">
                        <input type="email" class="input100" placeholder="Email" name="email">
                        <span class="focus-input100" data-placeholder="&#x2709;"></span>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn btn-block">Request New Password</button>
					</div>
					<br>
					<div class="contact100-form-checkbox">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<a class="txt1" href="{{ route('login') }}">Login</a><br>
						<a class="txt1" href="{{ route('register-account') }}">Register a new account</a>
					</div>

					<div class="text p-t-90">
						<br>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="{{ asset('jquery-1.9.1/jquery.min.js') }}"></script>
	<script>
		$(".alert").delay(5000).slideUp(600, function() {
			$(this).alert('close');
		});
	</script>

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

</body>
</html>