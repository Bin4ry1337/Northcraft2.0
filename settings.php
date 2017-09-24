<?php

include('header.php');

CheckLoggedIn();

?>

<div class="row">
	<div class="content column small-12">
		<div class="usercp-menu column small-12">
			<ul class="content-menu">
				<li><a href="usercp.php">Information</a></li>
				<li><a href="#" class="current">Settings</a></li>
			</ul>
		</div>

		<div class="usercp-box column small-12 medium-6 large-6">
			<div class="usercp-header2 column small-12">
				Change Password
			</div>

			<div class="usercp-text2 column small-12">
				<form method="POST">
					<label>Old Password</label>
					<input type="password" name="oldpassword" />

					<label>New Password</label>
					<input type="password" name="newpassword" />

					<label>Repeat Password</label>
					<input type="password" name="repassword" />

					<input type="submit" name="change" class="button small" value="Change Password" />
				</form>
			</div>

			<div class="usercp-response column small-12">
				<?php ChangePassword(); ?>
			</div>
		</div>

		<div class="usercp-box column small-12 medium-6 large-6">
			
		</div>
	</div>
</div>

<?php

include('footer.php');

?>