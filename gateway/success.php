<?php

session_start();

if(!isset($_GET['id']) || empty($_GET['id']))
{
	die('Your actions has been logged to our NSA Database.');
}

?>
<html>
<head>
	<title>Northcraft - Payment Gateway</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon.png">

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" type="text/css" href="../css/foundation.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/gateway.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/fonts.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/colors.css" media="screen" />
</head>
<body>

<div class="success">
	<div class="success-box">
		<div class="success-box-header">
			Thank you for your purchase
		</div>

		<div class="success-box-content">
			<?php 

			if($_GET['id'] == 1)
			{
				echo 'Your services has been added to your character!';
			}
			elseif($_GET['id'] == 2)
			{
				$code = $_GET['code'];

				echo 'Here is your redeem code: <br><span class="green"><pre>' . $code . '</pre></span>';
			}
			elseif($_GET['id'] == 3)
			{
				echo 'Thank you so much for your donation!';
			}

			?>

			<br>
			<br>

			<a href="../usercp.php" class="small button">Go back</a>
		</div>
	</div>
</div>
</body>
</html>