<?php

session_start();

include('inc/config.php');
include('inc/functions.php');

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
		<form action="gateway/checkout.php" method="POST">
			<div class="gateway-box-header">
				Payment Gateway
			</div>

			<div class="shop-item">
				<div id="tabs">
				  	<div class="tabs-header">
					  	<ul>
						    <li><a href="shop.php"       <?php echo (@$_GET['tab'] == "")?"class=\"current\"":"class=\"\""; ?>>Mounts</a></li>
						    <li><a href="?tab=pets"      <?php echo (@$_GET['tab'] == "pets")?"class=\"current\"":"class=\"\""; ?>>Pets</a></li>
						    <li><a href="?tab=cosmetics" <?php echo (@$_GET['tab'] == "cosmetics")?"class=\"current\"":"class=\"\""; ?>>Cosmetics</a></li>
					  	</ul>
				  	</div>

				  	<?php if(@$_GET['tab'] == "pets"): ?>
				  	
				  	<div id="tabs-1">
				    	<table>
							<?php GrabShopItems('PET'); ?>
						</table>
				    </div>

					<?php endif; ?>

					<?php if(@$_GET['tab'] == "cosmetics"): ?>
				  
				  	<div id="tabs-2">
				    	<table>
							<?php GrabShopItems('COSMETIC'); ?>
						</table>
				    </div>

					<?php endif; ?>
				  
					<?php if(@$_GET['tab'] == ""): ?>

				  	<div id="tabs-3">
				    	<table>
							<?php GrabShopItems('MOUNT'); ?>
						</table>
				    </div>

					<?php endif; ?>
				</div>
			</div>	
		</form>
	</div>
</div>

<script type="text/javascript" src="js/power.js"></script>
<script>
	var aowow_tooltips = { 
		"colorlinks": true, 
		"iconizelinks": true, 
		"renamelinks": true
	}
</script>

</body>
</html>