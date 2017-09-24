<?php

include('header.php');

CheckLoggedOut();

?>

<div class="row">
	<div class="content column small-12">
		<div class="box column small-12 medium-offset-3 medium-6 large-offset-4 large-4">
			<div class="box-content">
				<form method="POST">
					<div class="box-content-line">
						<div class="box-content-title">
							Reset Password
						</div>
					</div>

					<div class="box-content-line2">
						<label>New Password</label>
						<input type="password" name="password" />
					</div>

					<div class="box-content-line2">
						<label>Re Password</label>
						<input type="password" name="repassword" />
					</div>

					<div class="box-content-line2">
						<input type="submit" class="button small" name="reset" value="Confirm" />
					</div>
				</form>
			</div>

			<div class="box-content-response column small-12">
				<?php ResetPassword(); ?>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>