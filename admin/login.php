<?php

session_start();

include('inc/config.php');
include('inc/functions.php');

CheckLoggedOut();

?>
<html>
<head>
	<title>CoreCMS - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/foundation.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/fonts.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/colors.css" media="screen" />

	<!-- Javascript Stylesheets -->
	<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/foundation/foundation.js"></script>
	<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="row">
	<div class="content">
		<div class="login-box">
			<div class="login-box-header">
				Login Panel
			</div>

			<div class="login-box-content">
				<form method="POST">
					<label>Username</label>
					<input type="text" name="username" />

					<label>Password</label>
					<input type="password" name="password" />

					<div class="g-recaptcha" data-sitekey="6LdyZigUAAAAAKFAtIaenfGyTFNQjVO5ZmF-5zt0"></div>
					<br>
					
					<input type="submit" class="button small" name="login" value="Login" />
					<span class="response"><?php Login(); ?></span>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>