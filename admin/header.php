<?php

session_start();

include('inc/config.php');
include('inc/functions.php');

CheckLoggedIn();
Logout();

?>
<html>
<head>
	<title>CoreCMS - Project</title>
	<meta charset="UTF-8">
	<META name="ROBOTS" content="NOINDEX, NOFOLLOW">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/foundation.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/header.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/content.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/footer.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/fonts.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/colors.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/wbbtheme.css" media="screen" />
</head>
<body>
<div class="row">
	<div class="header columns small-12">
		<div class="row">
			<div class="header-top column small-12">
				<div class="website-title">
					<span class="lightning">Core</span><span class="bold">CMS</span>
				</div>
			</div>
		</div>
	</div>

	<div class="menu-admin">
		<ul class="main-menu">
			<?php Menu(); ?>
		</ul>
	</div>

	<div class="menu-right">
		<ul class="account-menu dropdown menu" data-dropdown-menu>
			<li><a href="#" <?php echo (basename($_SERVER["PHP_SELF"]) == "usercp.php")?"class=\"current-nav\"":""; ?> data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"><?php echo ucfirst($_SESSION['username']); ?></a>
				<ul id="drop1" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
					<li><a href="usercp.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "usercp.php")?"class=\"current-nav\"":""; ?>>UserCP</a></li>
					<li><a href="?logout=1">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>