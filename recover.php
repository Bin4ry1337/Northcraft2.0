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
							Recover Account
						</div>
					</div>

					<div class="box-content-line2">
						<label>Email</label>
						<input type="text" name="email" />
					</div>

					<div class="box-content-line2">
						<div class="g-recaptcha" data-sitekey="6LcJcyoUAAAAAIMDjra1vjG8YMvT889sISHO_1r0"></div>
						<br>
					</div>

					<div class="box-content-line2">
						<input type="submit" class="button small" name="recover" value="Recover" />
					</div>
				</form>
			</div>

			<div class="box-content-response column small-12">
				<?php RecoverPassword(); ?>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>