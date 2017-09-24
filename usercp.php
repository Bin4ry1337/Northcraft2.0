<?php

include('header.php');

CheckLoggedIn();

?>

<div class="row">
	<div class="content column small-12">
		<div class="usercp-menu column small-12">
			<ul class="content-menu">
				<li><a href="#" class="current">Information</a></li>
				<li><a href="settings.php">Settings</a></li>
			</ul>
		</div>

		<div class="usercp-box column small-12 medium-4 large-3">
			<div class="usercp-content column small-12">
				<label>Username</label>
				<?php GrabAccountData('username'); ?>
			</div>

			<div class="usercp-content column small-12">
				<label>Email</label>
				<?php GrabAccountData('email'); ?>
			</div>

			<div class="usercp-content column small-12">
				<label>Status</label>
				<?php GrabAccountStatus(); ?>
			</div>
		</div>

		<div class="usercp-box column small-12 medium-8 large-9">
			<div class="usercp-header column small-12">
				Characters
			</div>

			<div class="usercp-text column small-12">
				<?php GrabCharacters(); ?>
			</div>
		</div>

		<div class="usercp-box2 column small-12">
			<div class="account-option-box column small-12 medium-4 large-2 left">
				<a href="gateway.php?type=factionchange">
					<div class="account-option">
						<div class="account-option-img">
							<img src="img/icons/donation/factionchange.png" width="35">
						</div>

						<div class="account-option-text">
							Faction Change
						</div>
					</div>
				</a>
			</div>

			<div class="account-option-box column small-12 medium-4 large-2 left">
				<a href="gateway.php?type=racechange">
					<div class="account-option">
						<div class="account-option-img">
							<img src="img/icons/donation/racechange.png" width="35">
						</div>

						<div class="account-option-text">
							Race Change
						</div>
					</div>
				</a>
			</div>

			<div class="account-option-box column small-12 medium-4 large-2 left">
				<a href="redeem.php">
					<div class="account-option">
						<div class="account-option-img">
							<img src="img/icons/donation/redeemcode.png" width="35">
						</div>

						<div class="account-option-text">
							Redeem Code
						</div>
					</div>
				</a>
			</div>

			<div class="account-option-box column small-12 medium-4 large-2 left">
				<a href="shop.php">
					<div class="account-option">
						<div class="account-option-img">
							<img src="img/icons/donation/shop.png" width="35">
						</div>

						<div class="account-option-text">
							Vanity Shop
						</div>
					</div>
				</a>
			</div>

			<div class="account-option-box column small-12 medium-4 large-2 left">
				<a href="donate.php">
					<div class="account-option">
						<div class="account-option-img">
							<img src="img/icons/donation/donation.png" width="35">
						</div>

						<div class="account-option-text">
							Donate
						</div>
					</div>
				</a>
			</div>

			<div class="account-option-box column small-12 medium-4 large-2 left">
				
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>