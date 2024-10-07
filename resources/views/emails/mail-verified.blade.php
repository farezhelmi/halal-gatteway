<!DOCTYPE html>
<html>
<head>
	<title>Email Verification</title>
	<style type="text/css">
		body {
			font-family: Arial, sans-serif;
			font-size: 14px;
			line-height: 1.5;
			color: #333333;
			background-color: #f4f4f4;
			padding: 0;
			margin: 0;
		}

		.container {
			margin: 0 auto;
			padding: 5px;
			background-color: #ffffff;
		}

		h1 {
			font-size: 28px;
			margin-top: 0;
		}

		p {
			margin-top: 0;
		}

		button {
			background-color: #0693D9;
			color: #FFFFFF;
			padding: 10px 20px;
			border: none;
			border-radius: 3px;
			font-size: 16px;
			cursor: pointer;
		}

		button:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Email Verification</h1>
		<br>
        <p>Hi <strong>{{ $mailData['name'] }},</strong></p> 
		<p>Welcome to UM Nature</p>
		<p>Your account has been registered into the UM Nature system. Email verification is required before you can fully use this system.</p>
		<br>
		<p>System login information :</p>
		<p>Email : {{ $mailData['email'] }}</p>
		<p>Password : {{ $mailData['token'] }}</p>
		<br>
		<p>Please click the button below to confirm your email and activate your account.</p>
		<a href="{{ route('/verification', $mailData['token']) }}">
			<button type="button" class="btn btn-primary">Confirm Email</button>
		</a>
		<br><br>
		<p>If you have not made any account registration, please ignore this email. Thank you.</p>
	</div>
</body>
</html>