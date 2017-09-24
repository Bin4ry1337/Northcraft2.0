<?php

session_start();

?>
<html>
<head>
	<title>Northcraft - Payment Gateway</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon.png">

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/foundation.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/gateway.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/fonts.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/colors.css" media="screen" />
</head>
<body>

<div class="gateway">
	<div class="gateway-box">
		<form action="gateway/checkout.php" method="GET">
			<div class="gateway-box-header">
				Payment Gateway
			</div>

			<div class="gateway-item">
				<label>Amount (EUR)</label>
				<input type="text" name="amount" />
			</div>

			<div class="gateway-item">
				<input type="hidden" name="type" value="DONATE" />
				<input type="submit" class="small button" name="donate" value="Donate" />
			</div>
		</form>
	</div>
</div>

</body>
</html>