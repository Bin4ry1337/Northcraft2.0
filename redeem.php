<?php

include('header.php');

CheckLoggedIn();

?>

<div class="row">
	<div class="content column small-12">
		<div class="box column small-12 medium-offset-3 medium-6 large-offset-4 large-4">
			<div class="box-content">
				<form method="POST">
					<div class="box-content-line">
						<div class="box-content-title">
							Redeem Code
						</div>
					</div>

					<div class="box-content-line2">
						<label>Code</label>
						<input type="text" name="code" />
					</div>

					<div class="box-content-line2">
						<label>Character</label>
						<input type="text" name="character" />
					</div>

					<div class="box-content-line2">
						<div class="g-recaptcha" data-sitekey="6Le1ECsUAAAAAFrys_ryd50YPmVehwvUOdhg825c"></div>
						<br>
					</div>

					<div class="box-content-line2">
						<input type="submit" class="button small" name="redeem" value="Redeem" />
					</div>
				</form>
			</div>

			<div class="box-content-response column small-12">
				<?php RedeemCode(); ?>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>