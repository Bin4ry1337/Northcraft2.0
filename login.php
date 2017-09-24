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
							Login
						</div>
					</div>

					<div class="box-content-line2">
						<label>Username</label>
						<input type="text" name="username" />
					</div>

					<div class="box-content-line2">
						<label>Password</label>
						<input type="password" name="password" />
					</div>

					<div class="box-content-line2">
						<div class="g-recaptcha" data-sitekey="6Ld8gigTAAAAAAEF6MiiuKw0H0DybEVe4PDi0AaV"></div>
						<br>
					</div>

					<div class="box-content-line2">
						<input type="submit" class="button small" name="login" value="Login" />

						<a href="recover.php" class="recover-password">Forgot your password?</a>
					</div>
				</form>
			</div>

			<div class="box-content-response column small-12">
				<?php Login(); ?>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>