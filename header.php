<?php
session_start();

include('inc/config.php');
include('inc/functions.php');

Logout();

LoggingSystem();

Blacklist();

?>
<html class="no-js">
<head>
	<title>Northcraft</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<meta name="google-site-verification" content="Snceu-gCO2d3xOQhXDgzye9X9bv-y-qEuRBrAz0poy0" />

	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon.png">

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/foundation.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/header.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/content.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/footer.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/fonts.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/colors.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/timeline.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/armory.css" media="screen" />
</head>
<body>
<div class="header-strip show-for-large">
	<div class="row">
		<div class="header column small-12">
			<div class="header-content column small-12 medium-4 large-3">
				<div class="header-logo">
					<a href="index.php">
						<div class="header-logo-text">
							NORTHCRAFT
						</div>
					</a>
				</div>
			</div>

			<div class="header-content column small-12 medium-8 large-9">
				<div class="menu-right show-for-large">
					<ul class="main-menu dropdown menu" data-dropdown-menu>
						<li><a href="index.php"   <?php echo (basename($_SERVER["PHP_SELF"]) == "index.php" || basename($_SERVER["PHP_SELF"]) == "")?"class=\"current-nav\"":""; ?>>HOME</a></li>
						<li><a href="realms.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "realms.php" || basename($_SERVER["PHP_SELF"]) == "downloads.php" || basename($_SERVER["PHP_SELF"]) == "staff.php" || basename($_SERVER["PHP_SELF"]) == "timeline.php" || basename($_SERVER["PHP_SELF"]) == "faq.php")?"class=\"current-nav\"":""; ?>>INFORMATION</a>
							<ul class="menu">
								<li><a href="realms.php"  <?php echo (basename($_SERVER["PHP_SELF"]) == "realms.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Realm Status</a></li>
								<li><a href="downloads.php"  <?php echo (basename($_SERVER["PHP_SELF"]) == "downloads.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Downloads</a></li>
								<li><a href="staff.php"    <?php echo (basename($_SERVER["PHP_SELF"]) == "staff.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>The Team</a></li>
								<li><a href="timeline.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "timeline.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Timeline</a></li>
								<li><a href="faq.php"      <?php echo (basename($_SERVER["PHP_SELF"]) == "faq.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>FAQ</a></li>
							</ul>
						</li>
						
						<li><a href="streams.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "gallery.php" || basename($_SERVER["PHP_SELF"]) == "streams.php")?"class=\"current-nav\"":""; ?>>MEDIA</a>
							<ul class="menu">
								<!--<li><a href="gallery.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "gallery.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Gallery</a></li>-->
								<li><a href="streams.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "streams.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Live Streamers</a></li>
							</ul>
						</li>

						<li><a href="forums/">FORUMS</a></li>
						
						<li><a href="bugtracker/">BUG TRACKER</a></li>

						<li><a href="armory.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "armory.php" || basename($_SERVER["PHP_SELF"]) == "arenaladder.php" || basename($_SERVER["PHP_SELF"]) == "pvpladder.php" || basename($_SERVER["PHP_SELF"]) == "hallsoffame.php")?"class=\"current-nav\"":""; ?>>ARMORY</a>
							<ul class="menu">
								<li><a href="armory.php"      <?php echo (basename($_SERVER["PHP_SELF"]) == "armory.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Armory</a></li>
								<li><a href="arenaladder.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "arenaladder.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Arena Ladder</a></li>
								<li><a href="pvpladder.php"   <?php echo (basename($_SERVER["PHP_SELF"]) == "pvpladder.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>PvP Ladder</a></li>
								<li><a href="hallsoffame.php"   <?php echo (basename($_SERVER["PHP_SELF"]) == "hallsoffame.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Hall of Fame</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="header-strip2 show-for-large">
	<div class="row">
		<div class="header column small-12">
			<div class="header-content column small-12 medium-12 large-12">
				<div class="menu-right show-for-large">
					<ul class="account-menu">
						<?php if(!isset($_SESSION['username'])): ?>
							<li><a href="login.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "login.php")?"class=\"current-nav\"":""; ?>>Login</a></li>
						<?php else: ?>
							<li><a href="usercp.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "usercp.php" || basename($_SERVER["PHP_SELF"]) == "settings.php")?"class=\"current-nav\"":""; ?>>UserCP</a></li>
							<li><a href="?logout=1">Logout</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="header-mobile-strip hide-for-large">
	<div class="row">
		<div class="title-bar" data-responsive-toggle="mobile-menu" data-hide-for="large">
			<button class="menu-icon" type="button" data-toggle="mobile-menu"></button>
			<div class="title-bar-title">Menu</div>
		</div>

		<div class="top-bar" id="mobile-menu">
		    <ul class="dropdown menu" data-responsive-menu="drilldown large-accordion">
		        <li>
		            <a href="https://northcraft.org">Home</a>
		        </li>

		        <li>
		            <a href="#" <?php echo (basename($_SERVER["PHP_SELF"]) == "realms.php" || basename($_SERVER["PHP_SELF"]) == "downloads.php" || basename($_SERVER["PHP_SELF"]) == "staff.php" || basename($_SERVER["PHP_SELF"]) == "timeline.php" || basename($_SERVER["PHP_SELF"]) == "faq.php")?"class=\"current-mob-nav\"":""; ?>>Information</a>
		            
		            <ul class="menu vertical">
			            <li><a href="realms.php"   <?php echo (basename($_SERVER["PHP_SELF"]) == "realms.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Realm Status</a></li>
			            <li><a href="downloads.php"   <?php echo (basename($_SERVER["PHP_SELF"]) == "downloads.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Downloads</a></li>
			            <li><a href="staff.php"    <?php echo (basename($_SERVER["PHP_SELF"]) == "staff.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>The Team</a></li>
			            <li><a href="timeline.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "timeline.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Timeline</a></li>
			            <li><a href="faq.php" 	 <?php echo (basename($_SERVER["PHP_SELF"]) == "faq.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>FAQ</a></li>
			        </ul>
		        </li>

		        <li>
		            <a href="#" <?php echo (basename($_SERVER["PHP_SELF"]) == "gallery.php" || basename($_SERVER["PHP_SELF"]) == "streams.php")?"class=\"current-mob-nav\"":""; ?>>Media</a>
		            
		            <ul class="menu vertical">
		                <li><a href="streams.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "streams.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Live Streamers</a></li>
		            </ul>
		        </li>

			    <li>
			        <a href="forums/">Forums</a>
			    </li>

		        <li>
		            <a href="bugtracker/">Bug Tracker</a>
		        </li>

		        <li>
		            <a href="#" <?php echo (basename($_SERVER["PHP_SELF"]) == "armory.php" || basename($_SERVER["PHP_SELF"]) == "arenaladder.php" || basename($_SERVER["PHP_SELF"]) == "pvpladder.php" || basename($_SERVER["PHP_SELF"]) == "hallsoffame.php")?"class=\"current-mob-nav\"":""; ?>>Armory</a>
		            
		            <ul class="menu vertical">
			            <li><a href="armory.php"      <?php echo (basename($_SERVER["PHP_SELF"]) == "armory.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Armory</a></li>
			            <li><a href="arenaladder.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "arenaladder.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Arena Ladder</a></li>
			            <li><a href="pvpladder.php"   <?php echo (basename($_SERVER["PHP_SELF"]) == "pvpladder.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>PvP Ladder</a></li>
						<li><a href="hallsoffame.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "hallsoffame.php")?"class=\"current-sub-nav menu-item\"":"class=\"menu-item\""; ?>>Hall of Fame</a></li>
			        </ul>
		        </li>

		        <li>
		      	    <div class="splitter"></div>
		        </li>

		        <?php if(!isset($_SESSION['username'])): ?>
			        <li>
			            <a href="login.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "login.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Login</a>
			        </li>

			        <li>
			            <a href="register.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "register.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>Register</a>
			        </li>
			  	<?php else: ?>
			  		<li>
			            <a href="usercp.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "usercp.php" || basename($_SERVER["PHP_SELF"]) == "settings.php")?"class=\"current-mob-nav\"":"class=\"\""; ?>>UserCP</a>
			        </li>

			        <li>
			        	<a href="?logout=1">Logout</a>
			        </li>
			    <?php endif; ?>
		    </ul>
		</div>
	</div>

	<?php if(basename($_SERVER['PHP_SELF']) == in_array(basename($_SERVER['PHP_SELF']), $slider)): ?>
	<div class="timer-mob">
		<div id="timer-text3">
			COME AND JOIN THE FIGHT
		</div>

		<div id="timer-countdown3">
			set realmlist logon.northcraft.org
		</div>
	</div>
	<?php endif; ?>
</div>

<?php if(basename($_SERVER['PHP_SELF']) == in_array(basename($_SERVER['PHP_SELF']), $slider)): ?>
<div class="orbit-container show-for-large">
	<ul data-orbit data-options="animation:fade; timer_speed: 5000; animation_speed:1000; pause_on_hover:false; animation_speed:500; navigation_arrows:false; bullets:false;">
	    <li style="background-image: url('img/bg1.jpg');">
	    	<div class="row">
	    		<div class="timer">
	    			<div id="timer-text">
	    				COME AND JOIN THE FIGHT
	    			</div>

	    			<div id="timer-countdown">
	    				set realmlist logon.northcraft.org
	    			</div>
	    		</div>

	    		<div class="img-text">
	    			<div class="img-title">
	    				WELCOME TO NORTHCRAFT
	    			</div>

	    			<div class="img-content">
	    				Northcraft is a project that has been in development since March 2016. We're aiming to provide a solid and well-rounded server that focuses especially on endgame content. Northcraft will warmly welcome you to a new place you can call home. This is the Wrath of the Lich King experience you've been waiting for.
	    			</div>
	    		</div>

	    		<div class="front-realm">
	    			<?php Realm(1); ?>
	    		</div>

	    		<div class="front-register">
		    		<div class="register-box">
						<div class="register-box-content">
							<form method="POST">
								<div class="register-strip">
									<label>Username</label>
									<input type="text" name="username" placeholder="Your account name" />
								</div>

								<div class="register-strip">
									<label>Email</label>
									<input type="text" name="email" placeholder="Your valid email address" />
								</div>

								<div class="register-strip">
									<label>Password</label>
									<input type="password" name="password" placeholder="Your desired password" />
								</div>

								<div class="register-strip">
									<label>Re-Password</label>
									<input type="password" name="re-password" placeholder="Repeat your password" />
								</div>

								<div class="register-strip">
									<center><div class="g-recaptcha" data-sitekey="6LfUyQ4UAAAAACDCMqn_pFVy44_EpF59fcKwfG7W"></div></center>
								</div>

								<div class="register-strip2">
									<center><input type="submit" class="button createaccount" name="register" value="Create Account" /></center>
								</div>

					    		<div class="response">
					    			<?php Register(); ?>
				    			</div>
							</form>
						</div>
					</div>
				</div>

	    		<div class="front-video">
	    			<div class="front-video-title">
	    				COME AND JOIN US
	    			</div>

	    			<div class="front-video-content">
	    				<iframe width="500" height="283" src="https://www.youtube.com/embed/LGmrxHnWZjY" frameborder="0" allowfullscreen></iframe>
	    			</div>
	    		</div>
	    	</div>
	    </li>
	    
	    <!--<li style="background-image: url('img/bg2.jpg');">
	    	<div class="row">
	    		<div class="img-text">
	    			<div class="img-title">
	    				PROGRESSIVE CONTENT RELEASE
	    			</div>

	    			<div class="img-content">
	    				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	    				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	    				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	    				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	    				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	    				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	    			</div>
	    		</div>
	    	</div>
	    </li>-->
	</ul>
</div>
<?php endif; ?>