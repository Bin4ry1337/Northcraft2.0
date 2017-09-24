<?php

include('header.php');

?>

<div class="row">
	<div class="content column small-12">
		<div class="box column small-12 medium-offset-3 medium-6 large-offset-4 large-4">			
			<div class="box-content">
				<div class="box-content-line">
					<div class="box-content-title">
						Register
					</div>
				</div>

				<form method="POST">
					<div class="box-content-line2">
						<label>Username</label>
						<input type="text" name="username" />
					</div>

					<div class="box-content-line2">
						<label>Email</label>
						<input type="text" name="email" />
					</div>

					<div class="box-content-line2">
						<label>Password</label>
						<input type="password" name="password" />
					</div>

					<div class="box-content-line2">
						<label>Re-Password</label>
						<input type="password" name="re-password" />
					</div>

					<div class="box-content-line4">
						<div class="g-recaptcha" data-sitekey="6LfUyQ4UAAAAACDCMqn_pFVy44_EpF59fcKwfG7W"></div>
					</div>

					<div class="box-content-line2">
						<input type="submit" class="button small" name="register" value="Register" />
					</div>
				</form>
			</div>

			<div class="box-content-response column small-12">
				<?php Register(); ?>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>