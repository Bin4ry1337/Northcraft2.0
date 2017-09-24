<?php

session_start();

if(!isset($_GET['type']))
{
	die();
}

if($_GET['type'] == 'factionchange' || $_GET['type'] == 'racechange'):
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
				<label>Service</label>
				<?php

				if(isset($_GET['type']))
				{
					if($_GET['type'] == 'racechange')
					{
						$img  = 'racechange.png';
						$name = 'Race Change';

					}
					elseif($_GET['type'] == 'factionchange')
					{
						$img  = 'factionchange.png';
						$name = 'Faction Change';
					}
				}

				?>
				<div class="item">
					<img src="img/icons/donation/<?php echo $img; ?>"> <span class="white"><?php echo $name; ?></span>
				</div>
			</div>

			<div class="gateway-inputfield">
				<label>Character</label>
				<input type="text" name="character" placeholder="Please fill in character name" />
			</div>

			<div class="gateway-subtotal">
				<center>
					<label>SUBTOTAL</label>
					<?php

					if(isset($_GET['type']))
					{
						if($_GET['type'] == 'racechange')
						{
							$price = 10;
						}
						elseif($_GET['type'] == 'factionchange')
						{
							$price = 20;
						}
					}

					?>
					$<?php echo $price; ?>
					<input type="hidden" name="service" value="<?php echo $_GET['type'] ?>" />
					<input type="hidden" name="type" value="SERVICE" />
				</center>
			</div>

			<div class="gateway-button">
				<input type="submit" name="purchase" class="button small" value="Purchase" />
			</div>
		</form>
	</div>
</div>
</body>
</html>
<?php

endif;

?>