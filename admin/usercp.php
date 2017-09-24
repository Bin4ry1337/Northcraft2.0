<?php

include('header.php');

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 medium-6 large-4">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Change Password
				</div>

				<div class="content-box-content2 column small-12">
					<form method="POST">
						<label>Current Password</label>
						<input type="password" name="oldpassword" />

						<label>New Password</label>
						<input type="password" name="newpassword" />
						
						<label>Re-Password</label>
						<input type="password" name="repassword" />

						<input type="submit" class="button small" name="changepassword" value="Change" />

						<span class="response"><?php ChangePassword(); ?></span>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>